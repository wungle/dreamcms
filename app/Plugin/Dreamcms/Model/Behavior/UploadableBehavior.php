<?php

App::uses("FileUtility", 'Dreamcms.Lib');

class UploadableBehavior extends ModelBehavior
{

/**
 * Behavior config
 *
 * @var array
 */
	protected $config;

/**
 * Languages
 *
 * @var array
 */
	protected $languages;

/**
 * Setup Callback
 *
 * $config = array(
 *		'savePath' => 'path-to-save-the-uploaded-files',
 *		'fields' => array('field1', 'field2')
 * )
 *
 * @param Model $Model Model the behavior is being attached to.
 * @param array $config Array of configuration information.
 * @return boolean
 */
	public function setup(Model $Model, $config = array()) {
		$db = ConnectionManager::getDataSource($Model->useDbConfig);
		if (!$db->connected) {
			trigger_error(
				__d('cake_dev', 'Datasource %s for UploadableBehavior of model %s is not connected', $Model->useDbConfig, $Model->alias),
				E_USER_ERROR
			);
			return false;
		}

		if (!is_array($this->config))
			$this->config = array();

		$this->config[$Model->alias] = $config;
		return true;
	}

/**
 * Cleanup Callback unbinds bound translations and deletes setting information.
 *
 * @param Model $Model Model being detached.
 * @return void
 */
	public function cleanup(Model $Model) {
		if (isset($this->config[$Model->alias]))
			unset($this->config[$Model->alias]);
	}

/**
 * beforeFind Callback
 *
 * @param Model $Model Model find is being run on.
 * @param array $query Array of Query parameters.
 * @return array Modified query
 */
	public function beforeFind(Model $Model, $query) {
		return $query;
	}

/**
 * afterFind Callback
 *
 * @param Model $Model Model find was run on
 * @param array $results Array of model results.
 * @param boolean $primary Did the find originate on $model.
 * @return array Modified results
 */
	public function afterFind(Model $Model, $results, $primary = false) {
		return $results;
	}

/**
 * beforeValidate Callback
 *
 * @param Model $Model Model invalidFields was called on.
 * @param array $options Options passed from Model::save().
 * @return boolean
 * @see Model::save()
 */
	public function beforeValidate(Model $Model, $options = array()) {
		return true;
	}

/**
 * Restores model data to the original data.
 * This solves issues with saveAssociated and validate = first.
 *
 * @param Model $model
 * @return boolean
 */
	public function afterValidate(Model $Model) {
		return true;
	}

/**
 * beforeSave callback.
 *
 * Copies data into the runtime property when `$options['validate']` is
 * disabled. Or the runtime data hasn't been set yet.
 *
 * @param Model $Model Model save was called on.
 * @param array $options Options passed from Model::save().
 * @return boolean true.
 * @see Model::save()
 */
	public function beforeSave(Model $Model, $options = array()) {
		$rootPath = isset($this->config[$Model->alias]['savePath']) ? $this->config[$Model->alias]['savePath'] : '/files/uploads/';

		if (substr($rootPath, 0, 1) != '/')
			$rootPath = '/' . $rootPath;
		if (substr($rootPath, -1) != '/')
			$rootPath .= '/';

		$rootPath .= Inflector::tableize($Model->alias) . '/';

		$fieldCount = count($this->config[$Model->alias]['fields']);
		$data = $Model->data;
		foreach ($this->config[$Model->alias]['fields'] as $field)
		{
			// prevent error while saving file
			if (!isset($data[$Model->alias][$field]['tmp_name']) || !file_exists($data[$Model->alias][$field]['tmp_name']))
			{
				unset($data[$Model->alias][$field]);
				continue;
			}

			$savePath = $rootPath . $field . '/';
			if ($this->hasTranslateBehavior($Model))
				$savePath .= strtolower($Model->locale) . '/';

			FileUtility::createDirectory($savePath);

			$record_id = isset($data[$Model->alias][$Model->primaryKey]) ? $data[$Model->alias][$Model->primaryKey] : $Model->getNextAutoIncrementValue();

			if (isset($data[$Model->alias][$Model->primaryKey]))
			{
				$oldData = $Model->find(
					'first',
					array(
						'conditions' => array($Model->alias . '.' . $Model->primaryKey => $data[$Model->alias][$Model->primaryKey]),
						'limit' => 1,
						'recursive' => 0
					)
				);
				if ($oldData)
					$this->deleteUploadedFiles($Model, $oldData);
			}

			$data[$Model->alias]['extension'] = FileUtility::getFileExtension($data[$Model->alias][$field]['name']);
			$data[$Model->alias]['size'] = @filesize($data[$Model->alias][$field]['tmp_name']);
			$data[$Model->alias]['mime_type'] = isset($data[$Model->alias][$field]['type']) ? $data[$Model->alias][$field]['type'] : 'unknown';
			$data[$Model->alias]['category'] = FileUtility::getFileCategory($data[$Model->alias]['extension']);

			if ($data[$Model->alias]['category'] == 'Image')
			{
				$imageInfo = @getimagesize($data[$Model->alias][$field]['tmp_name']);
				$data[$Model->alias]['width'] = isset($imageInfo[0]) ? $imageInfo[0] : 0;
				$data[$Model->alias]['height'] = isset($imageInfo[1]) ? $imageInfo[1] : 0;
			}
			else
			{
				$data[$Model->alias]['width'] = 0;
				$data[$Model->alias]['height'] = 0;
			}

			$filename = $data[$Model->alias]['category'] == 'Image' ?
				$record_id . '_' . strtolower(Inflector::slug(trim($data[$Model->alias][$Model->displayField]), '_')) . '_' . $data[$Model->alias]['width'] . 'x' . $data[$Model->alias]['height'] . '.' . $data[$Model->alias]['extension'] :
				$record_id . '_' . strtolower(Inflector::slug(trim($data[$Model->alias][$Model->displayField]), '_')) . '.' . $data[$Model->alias]['extension'];

			move_uploaded_file($data[$Model->alias][$field]['tmp_name'], WWW_ROOT . FileUtility::stripBeginingSlashes($savePath) . $filename);
			@chmod(WWW_ROOT . FileUtility::stripBeginingSlashes($savePath) . $filename, 0666);

			$data[$Model->alias][$field] = $savePath . $filename;
		}

		$Model->data = $data;

		return true;
	}

/**
 * afterSave Callback
 *
 * @param Model $Model Model the callback is called on
 * @param boolean $created Whether or not the save created a record.
 * @param array $options Options passed from Model::save().
 * @return boolean
 */
	public function afterSave(Model $Model, $created, $options = array()) {
		return true;
	}

/**
 * beforeDelete Callback
 *
 * @param Model $Model Model the callback was run on.
 * @return boolean
 */
	public function beforeDelete(Model $Model, $cascade = true) {
		if ($this->hasTranslateBehavior($Model))
		{
			$this->fetchLanguages();
			foreach ($this->languages as $locale)
			{
				$Model->setLanguage($locale);
				$data = $Model->find(
					'first',
					array(
						'conditions' => array($Model->alias . '.' . $Model->primaryKey => $Model->id),
						'limit' => 1,
						'recursive' => 0
					)
				);
				$this->deleteUploadedFiles($Model, $data);
			}
		}
		else
		{
			$data = $Model->find(
				'first',
				array(
					'conditions' => array($Model->alias . '.' . $Model->primaryKey => $Model->id),
					'limit' => 1,
					'recursive' => 0
				)
			);
			$this->deleteUploadedFiles($Model, $data);
		}

		return true;
	}

/**
 * afterDelete Callback
 *
 * @param Model $Model Model the callback was run on.
 * @return boolean
 */
	public function afterDelete(Model $Model) {
		return true;
	}

/**
 * Delete all of uploaded files
 *
 * @param Model $Model The model being read.
 * @param array $data
 * @return boolean
 */
	protected function deleteUploadedFiles(Model $Model, $data)
	{
		foreach ($this->config[$Model->alias]['fields'] as $field)
		{
			if (!isset($data[$Model->alias][$field]))
				continue;

			$file = WWW_ROOT . FileUtility::stripBeginingSlashes($data[$Model->alias][$field]);
			if (file_exists($file))
				@unlink($file);
		}
	}

/**
 * Fetch all languages available
 *
 * @param null
 * @return boolean
 */
	protected function fetchLanguages() {
		if (is_array($this->languages))
			return true;

		$LanguageModel = ClassRegistry::init(array('class' => 'AppModel', 'alias' => 'UploadableLanguage'));
		$LanguageModel->setSource('languages');
		$this->languages = $LanguageModel->find(
			'list',
			array(
				'fields' => array('UploadableLanguage.name', 'UploadableLanguage.locale'),
				'conditions' => array('UploadableLanguage.deleted' => '0'),
				'order' => 'UploadableLanguage.name ASC',
				'recursive' => 0
			)
		);
		return true;
	}

/**
 * Check if a model has Translate Behavior
 *
 * @param Model $Model The model being read.
 * @return boolean
 */
	protected function hasTranslateBehavior(Model $Model) {
		foreach ($Model->actsAs as $key => $value)
			if (($key == 'Translate') || (!is_array($value) && ($value == 'Translate')))
				return true;

		return false;
	}
}

?>