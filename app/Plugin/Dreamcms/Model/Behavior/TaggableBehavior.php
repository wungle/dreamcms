<?php

class TaggableBehavior extends ModelBehavior
{

/**
 * Tag Model handler
 *
 * @var object
 */
	protected $Tag = null;
	
/**
 * Tagged Model handler
 *
 * @var object
 */
	protected $Tagged = null;
	
/**
 * Initializes Tag and Tagged models
 */
	public function setup(Model $Model, $config = array())
	{
		$this->Tag = ClassRegistry::init('Dreamcms.Tag');
		$this->Tagged = ClassRegistry::init('Dreamcms.Tagged');
	}
	
/**
 * Save tag and tagged models
 *
 * @param object $Model
 */
	public function afterSave(Model $Model, $created, $options = array())
	{
		if(!isset($Model->data[$Model->alias]['tags']))
		{
			return;
		}
		
		$tagged_conditions = array(
			'model'    => $Model->alias,
			'model_id' => $Model->id,
		);
		
		$this->Tagged->deleteAll($tagged_conditions, false, true);

		$tags = Set::normalize($Model->data[$Model->alias]['tags'], false);
		$tags = array_unique($tags);
		
		foreach($tags as $tag)
		{
			$this->Tag->saveTag($tag, $tagged_conditions);
		}
	}
	
/**
 * Delete tag relations with current Model Id
 *
 * @param object $Model
 */
	public function beforeDelete(Model $Model, $cascade = true)
	{
		if(!$Model->id)
		{
			return false;
		}
		
		$conditions = array(
			'model'    => $Model->alias,
			'model_id' => $Model->id,
		);
		
		$this->Tagged->deleteAll($conditions, false, true);
		
		return true;
	}
	
/**
 * Populates results array with a new field 'tags' with comma separated tag names
 * Only for 1 row results sets (find('first') or read())
 *
 * @param object $Model
 * @param array $results
 * @param array $primary
 * @return array
 */
	public function afterFind(Model $Model, $results, $primary = false)
	{
		if(count($results) == 1 && isset($results[0][$Model->alias][$Model->primaryKey]))
		{
			$tags = $this->Tagged->findTags(
				$Model->alias,
				$results[0][$Model->alias][$Model->primaryKey]
			);
					
			$results[0][$Model->alias]['tags'] = join(', ', Set::extract('/Tag/name', $tags));
		}
		
		return $results;
	}
	
/**
 * Finds tags related to a record
 *
 * @param object $Model
 * @param int $id Related model primary key
 * @return mixed Found related tags
 */
	public function findTags(Model $Model, $id = null)
	{
		if(!$id && !$Model->id)
		{
			return null;
		}
		
		if(!$id)
		{
			$id = $Model->id;
		}
		
		return $this->Tagged->findTags($Model->alias, $id);
	}
	
/**
 * Find used tags, model specific
 *
 * @param array $options Options (same as classic find options)
 * Two new keys available :
 * - min_count : minimum number of times a tag is used
 * - max_count : maximum number of times a tag is used
 * @return array
 */
	public function tagCloud(Model $Model, $options = array())
	{
		return $this->Tagged->tagCloud($Model->alias, $options);
	}

/**
 * Returns records that share the most tags with record of id $id
 *
 * @param object $Model
 * @param int $id Record Id
 * @param bool $restrict_to_model If true, returns related records of the same model, if false return all related records
 * @param int limit Limit the number of records
 * @return array Related records
 */
	public function findRelated(Model $Model, $id = null, $restrict_to_model = true, $limit = null)
	{
		if(is_bool($id))
		{
			$limit = $restrict_to_model;
			$restrict_to_model = $id;
			$id = null;
		}
		
		if(!$id && !$Model->id)
		{
			return;
		}
		
		if(!$id)
		{
			$id = $Model->id;
		}
		
		if(!$tags = $this->Tagged->findTags($Model->alias, $id))
		{
			return;
		}
		
		$tag_ids = Set::extract('/Tag/id', $tags);
		
		// Restrict to Model ?
		$taggedWith_model = null;
		
		if($restrict_to_model)
		{
			$taggedWith_model = $Model->alias;
		}
		
		// Exclude this record from results
		$exclude_ids = array_values($this->Tagged->find('list', array(
			'fields'     => 'id',
			'conditions' => array('model' => $Model->alias, 'model_id' => $id),
			'recursive'  => -1
		)));
		
		// Related records
		if(!$related = $this->Tagged->taggedWith($taggedWith_model, $tag_ids, $exclude_ids, $limit))
		{
			return;
		}
		
		// Final results
		if($restrict_to_model)
		{
			$model_ids = Set::extract('/Tagged/model_id', $related);
			
			$pk = $Model->escapeField($Model->primaryKey);
			
			$conditions = array($pk => $model_ids);
			$order = "FIELD({$pk}, " . join(', ', $model_ids) . ")";
			
			$results = $Model->find('all', compact('conditions', 'order'));
		}
		else
		{
			$results = array();
			
			foreach($related as $row)
			{
				if($assoc_model = ClassRegistry::init($row['Tagged']['model']))
				{
					$assoc_model->id = $row['Tagged']['model_id'];
		
					$results[] = $assoc_model->read();
				}
			}
		}

		return $results;
	}
}

?>