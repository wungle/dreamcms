<?php
App::uses('Cache', 'Cache');
App::uses('CacheEngine', 'Cache');
App::uses('DreamcmsAppModel', 'Dreamcms.Model');
App::uses("FileUtility", 'Dreamcms.Lib');

class CacheableModel extends DreamcmsAppModel
{
	protected $cacheConfigName;
	protected $cacheGroups;

	public function unbindModel($params, $reset = true) {
		$this->setupCache();

		return parent::unbindModel($params, $reset);
	}

	public function bindModel($params, $reset = true) {
		$result = parent::bindModel($params, $reset);

		$this->setupCache();

		return $result;
	}

	public function afterSave($created, $options = array())
	{
		$this->destroyCache();
		return parent::afterSave($created, $options);
	}

	public function afterDelete()
	{
		$this->destroyCache();
		return parent::afterDelete();
	}

	protected function _readDataSource($type, $query)
	{
		if (!$this->cacheConfigName)
			$this->setupCache();

		$cacheKey = $type . '_' . sha1(json_encode($query));
		$cache = Cache::read($cacheKey, $this->cacheConfigName);

		if (!Configure::read('Cache.disable') && ($cache !== false))
			return $cache;
		elseif ($cache !== false)
			$this->destroyCache();

		$results = parent::_readDataSource($type, $query);

		if (!Configure::read('Cache.disable'))
		{
			Cache::write($cacheKey, $results, $this->cacheConfigName);

			$cache_file = CACHE . 'cacheable_models' . DS . $this->cacheConfigName . DS . $cacheKey;
			if (file_exists($cache_file))
				@chmod($cache_file, 0666);
		}

		return $results;
	}

	protected function setupCache()
	{
		if (file_exists(CACHE . DS . 'persistent' . DS . 'myapp_cake_core_file_map'))
			@chmod(CACHE . DS . 'persistent' . DS . 'myapp_cake_core_file_map', 0666);

		if (!$this->cacheConfigName)
			$this->cacheConfigName = Inflector::underscore($this->alias);

		if (!$this->cacheDuration)
			$this->cacheDuration = '+360 days';

		if (!$this->cacheGroups || !is_array($this->cacheGroups))
			$this->cacheGroups = array();

		if (!in_array($this->cacheConfigName, $this->cacheGroups)) {
			$this->cacheGroups[] = $this->cacheConfigName;

			if (!Configure::read('App.SchemaCreate'))
				$this->createCacheConfig($this->cacheConfigName);
		}

		foreach (array('hasOne', 'hasMany', 'belongsTo', 'hasAndBelongsToMany') as $type)
		{
			if (isset($this->{$type}) && is_array($this->{$type}))
				foreach ($this->{$type} as $association)
				{
					if (isset($association['className']))
					{
						while (strpos($association['className'], '.') !== false)
							$association['className'] = substr($association['className'], strpos($association['className'], '.')+1);

						$association['className'] = Inflector::underscore($association['className']);

						if (!in_array($association['className'], $this->cacheGroups))
						{
							$this->cacheGroups[] = $association['className'];
							if (!Configure::read('App.SchemaCreate'))
								$this->createCacheConfig($association['className']);
						}
					}
				}
		}
	}

	public function destroyCache()
	{
		if (!$this->cacheConfigName)
			$this->setupCache();

		if (!Configure::read('App.SchemaCreate'))
			foreach ($this->cacheGroups as $group)
			{
				Cache::clear(false, $group);
				$this->forceClearDirectory(CACHE . 'cacheable_models' . DS . $group . DS);
			}
	}

	protected function forceClearDirectory($path)
	{
		if ((substr($path, -1) != '/') && (substr($path, -1) != '\\'))
			$path .= DS;

		if (!is_dir($path))
			return false;

		$handle = opendir($path);

		if ($handle)
		{
			while ( ($file = readdir($handle)) !== false )
			{
				if ( ($file != '.') && ($file != '..') )
				{
					if (!is_dir($path . $file))
						@unlink($path . $file);
				}
			}
			closedir($handle);
		}
	}

/**
 * createCacheConfig method
 * 
 * Recommendation :
 * use file engine for development environment
 * use memcached engine for staging / production environment
 *
 * @param string $configName
 * @return void
 */
	protected function createCacheConfig($configName) {
		FileUtility::createDirectory('cacheable_models' . DS . $configName, CACHE);

		Cache::config($configName, array(
			'engine' => 'File',
			'duration' => $this->cacheDuration,
			'probability' => 100,
			'path' => CACHE . 'cacheable_models' . DS . $configName . DS,
			//'groups' => $this->cacheGroups,
			'prefix' => null,
		));

		/*
		Cache::config($configName, array(
			'engine' => 'Memcache',
			'duration' => $this->cacheDuration,
			'probability' => 100,
	 		'prefix' => Inflector::slug(strtolower(Configure::read('DreamCMS.web_name')), '_') . '_',
	 		'servers' => array(
	 			'127.0.0.1:11211'
	 		),
	 		'persistent' => true,
	 		'compress' => false,
		));
		*/
	}
}

?>