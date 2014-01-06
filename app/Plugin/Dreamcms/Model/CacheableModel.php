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
		if (!Configure::read('Cache.disable'))
		{
			if (!$this->cacheConfigName)
			$this->setupCache();

			$cacheKey = $type . '_' . md5(json_encode($query));
			$cache = Cache::read($cacheKey, $this->cacheConfigName);

			if ($cache !== false)
				return $cache;
		}

		$results = parent::_readDataSource($type, $query);

		if (!Configure::read('Cache.disable'))
			Cache::write($cacheKey, $results, $this->cacheConfigName);

		return $results;
	}

	protected function setupCache()
	{
		$this->cacheConfigName = 'cacheable_models';
		$duration = (isset($this->cacheDuration)) ? $this->cacheDuration : '+15 days';

		$this->cacheGroups = array($this->alias);

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
							$this->cacheGroups[] = $association['className'];
					}
				}
		}

		Cache::config($this->cacheConfigName, array(
			'engine' => 'File',
			'duration' => $duration,
			'probability' => 100,
			'path' => CACHE . $this->cacheConfigName . DS,
			'groups' => $this->cacheGroups
		));
	}

	protected function destroyCache()
	{
		if (!$this->cacheConfigName)
			$this->setupCache();

		foreach ($this->cacheGroups as $group)
		{
			@Cache::clearGroup($group, $this->cacheConfigName);
			@Cache::clearGroup($group, Inflector::tableize($group));
		}
	}
}

?>