<?php

App::uses("ClassRegistry", 'Utility');
App::uses("Inflector", 'Utility');
App::uses("Set", 'Utility');
App::uses("String", 'Utility');
App::uses("FileUtility", 'Dreamcms.Lib');
App::uses("ImageResizer", 'Dreamcms.Lib');
App::uses("ThumbnailType", 'Dreamcms.Model');
App::uses("Thumbnail", 'Dreamcms.Model');

class ThumbnailableBehavior extends ModelBehavior
{

/**
 * Behavior config
 *
 * @var array
 */
	protected $config;

/**
 * Runtime Data
 *
 * @var array
 */
	protected $runtimeData;

/**
 * Runtime Model
 *
 * @var array
 */
	protected $runtimeModels;

/**
 * Thumbnail Types
 *
 * @var array
 */
	protected $thumbnailTypes;

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
				__d('cake_dev', 'Datasource %s for ThumbnailBehavior of model %s is not connected', $Model->useDbConfig, $Model->alias),
				E_USER_ERROR
			);
			return false;
		}

		if (!is_array($this->config))
			$this->config = array();

		if (!is_array($this->runtimeModels))
			$this->runtimeModels = array();

		$this->config[$Model->alias] = $config;

		$this->thumbnailModel($Model);
		if (isset($this->config[$Model->alias]['fields']))
			$this->bindThumbnail($Model, $this->config[$Model->alias]['fields']);

		return true;
	}

/**
 * Cleanup Callback unbinds bound translations and deletes setting information.
 *
 * @param Model $Model Model being detached.
 * @return void
 */
	public function cleanup(Model $Model) {
		if (isset($this->config[$Model->alias]['fields']))
			$this->unbindThumbnail($Model, $this->config[$Model->alias]['fields']);

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
		$locale = (isset($Model->locale) && !empty($Model->locale)) ? $Model->locale : 'en-US';

		if (!isset($this->config[$Model->alias]['locale']) || ($this->config[$Model->alias]['locale'] != $locale))
		{
			if (isset($this->config[$Model->alias]['fields'])) {
				$this->unbindThumbnail($Model, $this->config[$Model->alias]['fields']);
				$this->bindThumbnail($Model, $this->config[$Model->alias]['fields']);
			}
		}

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
		if (!is_array($this->runtimeData))
			$this->runtimeData = array();

		if (!isset($this->runtimeData[$Model->alias]))
			$this->runtimeData[$Model->alias] = array();

		$this->runtimeData[$Model->alias] = $Model->data;
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
		if (!is_array($this->thumbnailTypes))
			$this->fetchThumbnailTypes();

		$data = $this->runtimeData[$Model->alias];

		$record_id = isset($data[$Model->alias][$Model->primaryKey]) ? $data[$Model->alias][$Model->primaryKey] : $Model->id;
		$locale = (isset($Model->locale) && !empty($Model->locale)) ? $Model->locale : 'en-US';
		$RuntimeModel = $this->thumbnailModel($Model);

		if (!$record_id)
			return false;

		$rootPath = isset($this->config[$Model->alias]['savePath']) ? $this->config[$Model->alias]['savePath'] : '/files/thumbnails/';

		if (substr($rootPath, 0, 1) != '/')
			$rootPath = '/' . $rootPath;
		if (substr($rootPath, -1) != '/')
			$rootPath .= '/';

		$rootPath .= Inflector::tableize($Model->alias) . '/';

		if (isset($this->config[$Model->alias]['fields']))
		{
			foreach ($this->config[$Model->alias]['fields'] as $key => $value)
			{
				$field = is_numeric($key) ? $value : $key;

				if (!isset($data[$Model->alias][$field]))
					continue;

				if (!file_exists(WWW_ROOT . FileUtility::stripBeginingSlashes($data[$Model->alias][$field])))
				{
					trigger_error(
						__d('cake_dev', 'Can not create thumbnail for file: %s - the file does not exist.', $data[$Model->alias][$field]),
						E_USER_ERROR
					);
					return false;
				}

				$imageInfo = @getimagesize(WWW_ROOT . FileUtility::stripBeginingSlashes($data[$Model->alias][$field]));
				if (!$imageInfo)
					continue;

				$savePath = $rootPath . $field . '/';
				if ($this->hasTranslateBehavior($Model, $field))
					$savePath .= strtolower($Model->locale) . '/';

				foreach ($this->thumbnailTypes as $thumbnailType)
				{
					$path = $savePath . strtolower(Inflector::slug($thumbnailType['ThumbnailableThumbnailType']['name'], '_')) . '/';

					$img = new ImageResizer();
					$img->fromFile(WWW_ROOT . FileUtility::stripBeginingSlashes($data[$Model->alias][$field]));
					$img->setQuality(100);
					$img->getImageWidth();
					$img->getImageHeight();

					if (strtolower($thumbnailType['ThumbnailableThumbnailType']['method']) == 'crop')
					{
						$tmpfile = APP . 'tmp/' . String::uuid() . '.jpg';

						$ratio = max($thumbnailType['ThumbnailableThumbnailType']['width'] / $imageInfo[0] * 100, $thumbnailType['ThumbnailableThumbnailType']['height'] / $imageInfo[1] * 100);
						$dim = array(
							"w" => floor($imageInfo[0] * $ratio / 100),
							"h" => floor($imageInfo[1] * $ratio / 100)
						);
						$crop = array(
							"x" => abs(round(($dim["w"] - $thumbnailType['ThumbnailableThumbnailType']['width']) / 2)),
							"y" => abs(round(($dim["h"] - $thumbnailType['ThumbnailableThumbnailType']['height']) / 2))
						);

						$img->resizeTo($dim["w"], $dim["h"]);
						$img->setQuality(100); // Make sure the image's quality is maximum
						$img->saveFile($tmpfile, IMAGETYPE_JPEG);

						$img = new ImageResizer();
						$img->fromFile($tmpfile);
						$img->setQuality(100);
						$img->getImageWidth();
						$img->getImageHeight();
						$img->crop($crop["x"], $crop["y"], $thumbnailType['ThumbnailableThumbnailType']['width'], $thumbnailType['ThumbnailableThumbnailType']['height']);
						$img->getImageWidth();
						$img->getImageHeight();

						@unlink($tmpfile);
					}
					else
					{
						$ratio = min($thumbnailType['ThumbnailableThumbnailType']['width'] / $imageInfo[0] * 100, $thumbnailType['ThumbnailableThumbnailType']['height'] / $imageInfo[1] * 100);
						$dim = array(
							"w" => floor($imageInfo[0] * $ratio / 100),
							"h" => floor($imageInfo[1] * $ratio / 100)
						);
						
						// Resize image
						$img->resizeTo($dim["w"], $dim["h"]);
					}

					$filename = $path . $record_id . '_' . strtolower(Inflector::slug($data[$Model->alias][$Model->displayField], '_')) . '_' . $img->getImageWidth() . 'x' . $img->getImageHeight() . '.jpg';

					$thumbnailData = array(
						$RuntimeModel->alias => array(
							'thumbnail_type_id' => $thumbnailType['ThumbnailableThumbnailType']['id'],
							'name' => $thumbnailType['ThumbnailableThumbnailType']['name'],
							'model' => $Model->alias,
							'foreign_key' => $record_id,
							'field' => $field,
							'locale' => $locale,
							'filename' => $filename,
							'width' => $img->getImageWidth(),
							'height' => $img->getImageHeight(),
						)
					);

					// Check if there's an existing thumbnail
					$conditions = array(
						$RuntimeModel->alias . '.thumbnail_type_id' => $thumbnailType['ThumbnailableThumbnailType']['id'],
						$RuntimeModel->alias . '.model' => $Model->alias,
						$RuntimeModel->alias . '.foreign_key' => $record_id,
						$RuntimeModel->alias . '.field' => $field,
					);
					if ($this->hasTranslateBehavior($Model, $field))
						$conditions[$RuntimeModel->alias . '.locale'] = $locale;
					$existingData = $RuntimeModel->find('first', array('conditions' => $conditions));
					if ($existingData)
					{
						@unlink(WWW_ROOT . FileUtility::stripBeginingSlashes($existingData[$RuntimeModel->alias]['filename']));
						$thumbnailData[$RuntimeModel->alias]['id'] = $existingData[$RuntimeModel->alias]['id'];
					}

					// Save current thumbnail information
					$RuntimeModel->create();
					$RuntimeModel->save($thumbnailData);

					// Save the thumbnail
					FileUtility::createDirectory($path);
					$img->setQuality(100); // Make sure the image's quality is maximum
					$img->saveFile(WWW_ROOT . FileUtility::stripBeginingSlashes($filename), IMAGETYPE_JPEG);
					@chmod(WWW_ROOT . FileUtility::stripBeginingSlashes($filename), 0666);
				}
			}
		}

		return true;
	}

/**
 * beforeDelete Callback
 *
 * @param Model $Model Model the callback was run on.
 * @return boolean
 */
	public function beforeDelete(Model $Model, $cascade = true) {
		$locale = (isset($Model->locale) && !empty($Model->locale)) ? $Model->locale : 'en-US';
		$RuntimeModel = $this->thumbnailModel($Model);

		if (isset($this->config[$Model->alias]['fields']))
		{
			foreach ($this->config[$Model->alias]['fields'] as $key => $value)
			{
				$field = is_numeric($key) ? $value : $key;

				$conditions = array(
					$RuntimeModel->alias . '.model' => $Model->alias,
					$RuntimeModel->alias . '.foreign_key' => $Model->id,
					$RuntimeModel->alias . '.field' => $field,
				);
				if ($this->hasTranslateBehavior($Model, $field))
					$conditions[$RuntimeModel->alias . '.locale'] = $locale;

				$allData = $RuntimeModel->find('all', $conditions);

				foreach ($allData as $data)
				{
					@unlink(WWW_ROOT . FileUtility::stripBeginingSlashes($data[$RuntimeModel->alias]['filename']));
					$RuntimeModel->id = $data[$RuntimeModel->alias]['id'];
					$RuntimeModel->delete();
				}
			}
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
 * Get instance of current thumbnail model
 *
 * @param Model $Model The model being read.
 * @return Model Object
 */
	protected function thumbnailModel(Model $Model)
	{
		if (!isset($this->runtimeModels[$Model->alias]))
		{
			$className = (isset($Model->thumbnailModel) && !empty($Model->thumbnailModel)) ? $Model->thumbnailModel : 'Dreamcms.Thumbnail';
			$tableName = (isset($Model->thumbnailTable) && !empty($Model->thumbnailTable)) ? $Model->thumbnailTable : 'thumbnails';

			$this->runtimeModels[$Model->alias] = ClassRegistry::init($className);
			$this->runtimeModels[$Model->alias]->setSource($tableName);
		}
		return $this->runtimeModels[$Model->alias];
	}

/**
 * Bind thumbnails for fields with hasMany association
 *
 * @param Model $Model The model being read.
 * @param array $fields The specified fields.
 * @return boolean
 */
	protected function bindThumbnail(Model $Model, $fields)
	{
		//$className = (isset($Model->thumbnailModel) && !empty($Model->thumbnailModel)) ? $Model->thumbnailModel : 'Dreamcms.Thumbnail';
		$locale = (isset($Model->locale) && !empty($Model->locale)) ? $Model->locale : 'en-US';

		$RuntimeModel = $this->thumbnailModel($Model);
		$associations = array();
		$default = array('className' => $RuntimeModel->alias, 'foreignKey' => 'foreign_key');

		if (isset($this->config[$Model->alias]['fields']))
		{
			foreach ($this->config[$Model->alias]['fields'] as $key => $value)
			{
				if (is_numeric($key))
				{
					$field = $value;
					$association = $field . 'Thumbnails';
				}
				else
				{
					$field = $key;
					$association = $value;
				}

				foreach (array('hasOne', 'hasMany', 'belongsTo', 'hasAndBelongsToMany') as $type) {
					if (isset($Model->{$type}[$association]) || isset($Model->__backAssociation[$type][$association])) {
						trigger_error(
							__d('cake_dev', 'Association %s is already bound to model %s', $association, $Model->alias),
							E_USER_ERROR
						);
						return false;
					}
				}

				if ($this->hasTranslateBehavior($Model, $field))
				{
					$associations[$association] = array_merge($default, array('conditions' => array(
						'model' => $Model->alias,
						'field' => $field,
						'locale' => $locale
					)));
				}
				else
				{
					$associations[$association] = array_merge($default, array('conditions' => array(
						'model' => $Model->alias,
						'field' => $field,
					)));
				}
			}

			$Model->bindModel(array('hasMany' => $associations));
		}

		$this->config[$Model->alias]['locale'] = $locale;
		return true;
	}

/**
 * Unbind thumbnails for fields, automatically unbind hasMany association for specified fields
 *
 * @param Model $Model The model being read.
 * @param array $fields The specified fields.
 * @return boolean
 */
	protected function unbindThumbnail(Model $Model, $fields)
	{
		$associations = array();

		if (isset($this->config[$Model->alias]['fields']))
		{
			foreach ($this->config[$Model->alias]['fields'] as $key => $value)
			{
				if (is_numeric($key))
				{
					$field = $value;
					$association = $field . 'Thumbnails';
				}
				else
				{
					$field = $key;
					$association = $value;
				}

				$associations[] = $association;
			}

			if (!empty($associations))
				$Model->unbindModel(array('hasMany' => $associations), false);
		}

		return true;
	}

/**
 * Fetch all thumbnail types available
 *
 * @param null
 * @return boolean
 */
	protected function fetchThumbnailTypes() {
		if (is_array($this->thumbnailTypes))
			return true;

		$ThumbnailTypeModel = ClassRegistry::init(array('class' => 'AppModel', 'alias' => 'ThumbnailableThumbnailType'));
		$ThumbnailTypeModel->setSource('thumbnail_types');
		$this->thumbnailTypes = $ThumbnailTypeModel->find(
			'all',
			array(
				'conditions' => array('ThumbnailableThumbnailType.deleted' => '0'),
				'order' => 'ThumbnailableThumbnailType.id ASC',
				'recursive' => 0
			)
		);
		return true;
	}

/**
 * Check if a field has Translate Behavior
 *
 * @param Model $Model The model being read.
 * @param string $field The field being read.
 * @return boolean
 */
	protected function hasTranslateBehavior(Model $Model, $field) {
		if (isset($Model->actsAs['Translate']))
			foreach ($Model->actsAs['Translate'] as $key => $value)
			{
				$currentField = is_numeric($key) ? $value : $key;
				if ($currentField == $field)
					return true;
			}

		return false;
	}

}

?>