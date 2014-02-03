<?php

App::uses('CakeSession', 'Model/Datasource');
App::uses("FileUtility", 'Dreamcms.Lib');
App::uses("ImageResizer", 'Dreamcms.Lib');

class LogableBehavior extends ModelBehavior
{

/**
 * Behavior config
 *
 * @var array
 */
	protected $config;

/**
 * Data Before Save
 *
 * @var array
 */
	protected $dataBeforeSave;

/**
 * Data After Save
 *
 * @var array
 */
	protected $dataAfterSave;

/**
 * Languages
 *
 * @var array
 */
	protected $languages;

/**
 * Model's Schema
 *
 * @var array
 */
	protected $modelSchema;

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
				__d('cake_dev', 'Datasource %s for LogableBehavior of model %s is not connected', $Model->useDbConfig, $Model->alias),
				E_USER_ERROR
			);
			return false;
		}

		if (!is_array($this->config))
			$this->config = array();

		$this->config[$Model->alias] = $config;

		$this->fetchLanguages();

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
		if (!is_array($this->dataBeforeSave))
			$this->dataBeforeSave = array();

		$pk = $Model->primaryKey;
		if (isset($Model->data[$Model->alias][$pk]) && !empty($Model->data[$Model->alias][$pk]))
		{
			// only fetch current data once for multi language transaction
			if (isset($this->dataBeforeSave[$Model->alias]) && method_exists($Model, 'multiLanguageTransaction') && ($Model->multiLanguageTransaction() > 0))
				return true;

			$this->dataBeforeSave[$Model->alias] = $this->fetchCurrentData($Model, $Model->data[$Model->alias][$pk]);
		}
		else
			$this->dataBeforeSave[$Model->alias] = null;

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
		if (method_exists($Model, 'multiLanguageTransaction') && ($Model->multiLanguageTransaction() === 1))
			return true;

		$pk = $Model->primaryKey;
		$id = (isset($Model->data[$Model->alias][$pk]) && !empty($Model->data[$Model->alias][$pk])) ? $Model->data[$Model->alias][$pk] : $Model->id;

		if (!is_array($this->dataAfterSave))
			$this->dataAfterSave = array();

		// Destroy cache before retrieving current data - for cacheable models
		if (method_exists($Model, 'destroyCache') && is_subclass_of($Model, 'CacheableModel'))
			@$Model->destroyCache();

		$this->dataAfterSave[$Model->alias] = $this->fetchCurrentData($Model, $id);

		if (empty($this->dataAfterSave[$Model->alias]))
			$this->dataAfterSave[$Model->alias] = null;

		$this->saveLog($Model);

		return true;
	}

/**
 * beforeDelete Callback
 *
 * @param Model $Model Model the callback was run on.
 * @return boolean
 */
	public function beforeDelete(Model $Model, $cascade = true) {
		if (!is_array($this->dataBeforeSave))
			$this->dataBeforeSave = array();

		$this->dataBeforeSave[$Model->alias] = $this->fetchCurrentData($Model, $Model->id);

		return true;
	}

/**
 * afterDelete Callback
 *
 * @param Model $Model Model the callback was run on.
 * @return boolean
 */
	public function afterDelete(Model $Model) {
		if (!is_array($this->dataAfterSave))
			$this->dataAfterSave = array();

		$this->dataAfterSave[$Model->alias] = null;

		$this->saveLog($Model);

		return true;
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
		{
			if (strval($key) == 'Translate')
				return true;
		}

		return false;
	}

/**
 * Fetch current data
 *
 * @param Model $Model The model being read.
 * @param integer $id the primary key's value
 * @return array data
 */
	protected function fetchCurrentData(Model $Model, $id)
	{
		$pk = $Model->primaryKey;

		$conditions = array(
			$Model->alias . '.' . $pk => $id,
		);

		if ($this->hasDeletedField($Model))
			$conditions[$Model->alias . '.deleted'] = '0';

		$current_schema = $this->fetchModelSchema($Model);
		$fields = array();
		foreach ($current_schema as $fieldname => $desc)
			$fields[] = $Model->alias . '.' . $fieldname;


		$result = $Model->find("first", array(
			'fields' => $fields,
			'conditions' => $conditions,
			'limit' => 1
		));

		if (empty($result))
			return $result;
		
		if ($this->hasTranslateBehavior($Model))
		{
			foreach ($Model->actsAs['Translate'] as $field => $association)
			{
				if (is_numeric($field))
				{
					$field = $association;
					$association = $field . 'Translation';
				}

				if ( Set::check($result, $Model->alias . '.' . $field) )
					$result[$Model->alias][$field] = Set::combine(
						$result[$association],
						"{n}.locale",
						"{n}.content"
					);
			}
		}

		// Check uploadable fields
		$uploadable = null;
		if (isset($Model->actsAs['Dreamcms.Uploadable']))
			$uploadable = $Model->actsAs['Dreamcms.Uploadable'];
		elseif (isset($Model->actsAs['Uploadable']))
			$uploadable = $Model->actsAs['Uploadable'];

		if (isset($uploadable['fields']) && is_array($uploadable['fields']) && !empty($uploadable['fields']))
		{
			foreach ($uploadable['fields'] as $uploadable_field)
			{
				if (!isset($result[$Model->alias][$uploadable_field]))
					continue;

				$thumbnail_field = $uploadable_field . '_uploadable_thumbnail';
				$filesize_field = $uploadable_field . '_uploadable_filesize';

				if (is_array($result[$Model->alias][$uploadable_field]))
				{
					$result[$Model->alias][$thumbnail_field] = array();
					$result[$Model->alias][$filesize_field] = array();
					foreach ($result[$Model->alias][$uploadable_field] as $locale => $value)
					{
						$filename = WWW_ROOT . FileUtility::stripBeginingSlashes($result[$Model->alias][$uploadable_field][$locale]);
						if (file_exists($filename))
						{
							$result[$Model->alias][$filesize_field][$locale] = filesize($filename);
							$thumbnail = $this->generateThumbnail($filename);
							if ($thumbnail)
								$result[$Model->alias][$thumbnail_field][$locale] = $thumbnail;
						}
					}
				}
				else
				{
					$filename = WWW_ROOT . FileUtility::stripBeginingSlashes($result[$Model->alias][$uploadable_field]);
					if (file_exists($filename))
					{
						$result[$Model->alias][$filesize_field] = filesize($filename);
						$thumbnail = $this->generateThumbnail($filename);
						if ($thumbnail)
							$result[$Model->alias][$thumbnail_field] = $thumbnail;
					}
				}
			}
		}

		// Fix unbinded belongsTo associations
		foreach ($Model->belongsTo as $alias => $config)
			if (!isset($result[$alias]))
			{
				$belongsToModel = ClassRegistry::init(array('class' => $config['className'], 'alias' => 'Logable' . $alias));
				
				$conditions = array('Logable' . $alias . '.' . $belongsToModel->primaryKey => $result[$Model->alias][$config['foreignKey']]);
				if (isset($config['conditions']) && is_array($config['conditions']) && !empty($config['conditions']))
					$conditions = Set::merge($conditions, $config['conditions']);

				$belongsToData = $belongsToModel->find(
					'first',
					array(
						'conditions' => $conditions,
						'limit' => 1
					)
				);

				if ($belongsToData)
					$result[$alias] = $belongsToData['Logable' . $alias];

				unset($belongsToModel);
			}
		
		return $result;
	}

/**
 * Fetch the model's schema
 *
 * @param Model $Model The model being read.
 * @return array schema
 */
	protected function fetchModelSchema(Model $Model)
	{
		if (!is_array($this->modelSchema))
			$this->modelSchema = array();

		if (!isset($this->modelSchema[$Model->alias]))
			$this->modelSchema[$Model->alias] = $Model->schema();

		return $this->modelSchema[$Model->alias];
	}

/**
 * Check if a model has deleted field
 *
 * @param Model $Model The model being read.
 * @return boolean
 */
	protected function hasDeletedField(Model $Model)
	{
		$schema = $this->fetchModelSchema($Model);

		return (isset($schema['deleted'])) ? true : false;
	}

/**
 * Check if a model has a specified field or not
 *
 * @param Model $Model The model being read.
 * @return boolean
 */
	protected function fieldExists(Model $Model, $field)
	{
		$schema = $this->fetchModelSchema($Model);

		return (isset($schema[$field])) ? true : false;
	}

/**
 * Save log
 *
 * @param Model $Model The model being read.
 * @return boolean - success
 */
	protected function saveLog(Model $Model)
	{
		$before = $this->dataBeforeSave[$Model->alias];
		$after = $this->dataAfterSave[$Model->alias];

		$operation = 'unknown';
		if (empty($before) && !empty($after))
			$operation = 'create';
		elseif (!empty($before) && !empty($after))
			$operation = 'update';
		elseif (!empty($before) && empty($after))
			$operation = 'delete';

		if ($operation == 'unknown')
			return false;

		$pk = $Model->primaryKey;

		$id = null;
		if (isset($before[$Model->alias][$pk]) && !empty($before[$Model->alias][$pk]))
			$id = $before[$Model->alias][$pk];
		elseif (isset($after[$Model->alias][$pk]) && !empty($after[$Model->alias][$pk]))
			$id = $after[$Model->alias][$pk];

		if (!$id)
			return false;

		$dreamcms_user = CakeSession::read('Auth.User');

		if (!$dreamcms_user)
			return false;

		$CmsLog = ClassRegistry::init(array('class' => 'AppModel', 'alias' => 'CmsLog'));
		$CmsLog->setSource('cms_logs');

		$operated_data = ($operation == 'create') ? 'a new record' : 'an existing record';

		$description = $dreamcms_user['real_name'] . ' (' . $dreamcms_user['username'] . ') has ' . $operation . 
			'd ' . $operated_data . ' on the "' . Inflector::humanize(Configure::read('DreamCMS.Routeable.current_controller')) . 
			'" menu.';

		// Special case for login operation
		if (($Model->alias == 'Admin') && ($operation == 'update') && (strpos(implode(', ', $this->getUpdatedFields($Model, $before, $after)), 'last_login') !== false))
		{
			$operation = 'login';
			$description = $dreamcms_user['real_name'] . ' (' . $dreamcms_user['username'] . ') has logged in.';
		}

		$data = array(
			'CmsLog' => array(
				'admin' => serialize($dreamcms_user),
				'controller' => Inflector::camelize(Configure::read('DreamCMS.Routeable.current_controller')),
				'model' => $Model->alias,
				'foreign_key' => $id,
				'fields' => implode(', ', $this->getUpdatedFields($Model, $before, $after)),
				'operation' => $operation,
				'description' => $description,
				'url' => strval($this->getUpdateTraceUrl($id, $CmsLog->getNextAutoIncrementValue())),
				'data_before' => serialize($before),
				'data_after' => serialize($after)
			)
		);

		$CmsLog->create();
		$CmsLog->save($data);

		return true;
	}

/**
 * Generate thumbnail
 *
 * @param String $filename - full file path
 * @return base64 encoded string
 * @return false - if the file is not an image.
 */
	protected function generateThumbnail($filename)
	{
		$imageInfo = @getimagesize($filename);
		if ($imageInfo === false)
			return false;

		$thumbnail = WWW_ROOT . 'temp/LT_' . String::uuid() . '.jpg';

		$img = new ImageResizer();
		$img->fromFile($filename);
		$img->setQuality(70);
		$img->getImageWidth();
		$img->getImageHeight();

		$ratio = min(240 / $imageInfo[0] * 100, 180 / $imageInfo[1] * 100);
		$dim = array(
			"w" => floor($imageInfo[0] * $ratio / 100),
			"h" => floor($imageInfo[1] * $ratio / 100)
		);
		
		// Resize image
		$img->resizeTo($dim["w"], $dim["h"]);

		$img->saveFile($thumbnail);
		$result = base64_encode(file_get_contents($thumbnail));

		@unlink($thumbnail);

		return $result;
	}

/**
 * Get updated fields
 *
 * @param Model $Model
 * @param array $before
 * @param array $after
 * @return array updated fields
 */
	protected function getUpdatedFields(Model $Model, $before, $after)
	{
		$test = (isset($before[$Model->alias]) && !empty($before[$Model->alias])) ? $before : $after;

		$standard_fields = array('id', 'lft', 'rght', 'created', 'modified', 'deleted');
		$result = array();

		foreach ($test[$Model->alias] as $field => $value)
		{
			if (in_array($field, $standard_fields) || !$this->fieldExists($Model, $field))
				continue;

			if (is_array($value))
			{
				$translated_before = (isset($before[$Model->alias][$field]) && !empty($before[$Model->alias][$field])) ? $before[$Model->alias][$field] : array();
				$translated_after = (isset($after[$Model->alias][$field]) && !empty($after[$Model->alias][$field])) ? $after[$Model->alias][$field] : array();

				if ($this->compareTranslatedData($translated_before, $translated_after))
					$result = Set::merge($result, array($field));
			}
			else
			{
				if (!isset($before[$Model->alias][$field]))
					$result = Set::merge($result, array($field));
				elseif (!isset($after[$Model->alias][$field]))
					$result = Set::merge($result, array($field));
				elseif ($before[$Model->alias][$field] != $after[$Model->alias][$field])
					$result = Set::merge($result, array($field));
			}
		}

		return $result;
	}

/**
 * Compare translated data
 *
 * @param array $before
 * @param array $after
 * @return boolean - updated
 */
	protected function compareTranslatedData($before, $after)
	{
		$test = (!empty($before)) ? $before : $after;

		foreach ($test as $locale => $value)
		{
			if (!isset($before[$locale]))
				return true;
			if (!isset($after[$locale]))
				return true;
			if ($before[$locale] != $after[$locale])
				return true;
		}

		return false;
	}

/**
 * Get update trace url
 *
 * @param integer $record_id
 * @param integer $log_id
 * @return string url
 */
	protected function getUpdateTraceUrl($record_id, $log_id)
	{
		$controller = Configure::read('DreamCMS.Routeable.current_controller');
		$params_here = Configure::read('App.params_here');

		if (substr($params_here, 0, 1) != '/')
			$params_here = '/' . $params_here;

		$test = explode('/', $params_here);
		$x = count($test) - 1;
		while ($test[$x] != $controller)
		{
			array_pop($test);
			$x = count($test) - 1;

			if ($x < 0)
				break;
		}

		return (empty($test)) ? null : implode('/', $test) . '/trace/' . $record_id . '/' . $log_id;
	}
}

?>