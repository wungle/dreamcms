<?php
App::uses('Cache', 'Cache');
App::uses('CacheEngine', 'Cache');
App::uses('DreamcmsAppModel', 'Dreamcms.Model');

class CacheableModel extends DreamcmsAppModel
{
	protected $cacheConfigName;
	protected $cacheGroups;

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

		$this->cacheConfigName = Inflector::tableize($this->alias);
		$duration = (isset($this->cacheDuration)) ? $this->cacheDuration : '+30 days';

		$this->cacheGroups = array($this->alias);
		if (!Configure::read('App.SchemaCreate'))
			Cache::config($this->cacheConfigName, array(
				'engine' => 'File',
				'duration' => $duration,
				'probability' => 100,
				'path' => CACHE . 'cacheable_models' . DS . $this->cacheConfigName . DS,
				//'groups' => $this->cacheGroups,
				'prefix' => null,
			));

		foreach (array('hasOne', 'hasMany', 'belongsTo', 'hasAndBelongsToMany') as $type)
		{
			if (isset($this->{$type}) && is_array($this->{$type}))
				foreach ($this->{$type} as $association)
				{
					if (isset($association['className']))
					{
						while (strpos($association['className'], '.') !== false)
							$association['className'] = substr($association['className'], strpos($association['className'], '.')+1);
						if (!in_array($association['className'], $this->cacheGroups))
						{
							$this->cacheGroups[] = $association['className'];
							if (!Configure::read('App.SchemaCreate'))
								Cache::config(Inflector::tableize($association['className']), array(
									'engine' => 'File',
									'duration' => $duration,
									'probability' => 100,
									'path' => CACHE . 'cacheable_models' . DS . Inflector::tableize($association['className']) . DS,
									//'groups' => $this->cacheGroups,
									'prefix' => null,
								));
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
				Cache::clear(false, Inflector::tableize($group));
				$this->forceClearDirectory(CACHE . 'cacheable_models' . DS . Inflector::tableize($group) . DS);
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
}

?>