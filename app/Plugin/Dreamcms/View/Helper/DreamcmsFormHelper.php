<?php

class DreamcmsFormHelper extends AppHelper
{
	// Required in cake 2.0++
	function __construct(View $view, $settings = array())
	{
		parent::__construct($view, $settings);
		//debug($options);
	}
	
	public function treeSelect($params)
	{
		$lnbr = "\r\n";
		$params = array_merge(
			array(
				'model' => null,
				'field' => 'parent_id',
				'tree' => array(),
				'class' => null,
				'no_parent_option' => false,
				'hidden' => null,
				'current' => null,
				'label' => true
			),
			$params
		);
		$params['class'] = (!empty($params['class'])) ? ' class="' . $params['class'] . '"' : "";

		$label = $params['field'];
		if (substr($label, -3) === '_id') {
			$label = substr($label, 0, -3);
		}
		
		$result = '';

		if ($params['label'])
			$result .= $lnbr . '<label for="'. $params['model'] . Inflector::camelize($params['field']) .'">'. Inflector::humanize($label) .'</label>' . $lnbr;

		$result .= $lnbr . '<select name="data['. $params['model'] .']['. $params['field'] .']" id="'. $params['model'] . Inflector::camelize($params['field']) .'"'. $params['class'] .'>' . $lnbr;
		
		if ($params['no_parent_option'])
			$result .= '<option value="0">No Parent</option>';
		
		$pad_count = 0;
		$last_item = '';
		$last_hidden_pad = -1;
		foreach ($params['tree'] as $key => $val)
		{
			$cur = substr_count($val, '_');
			
			if ($key == $params['hidden'])
			{
				$last_hidden_pad = $cur;
				continue;
			}
			
			if (($last_hidden_pad > -1) && ($cur > $last_hidden_pad))
				continue;
			else
				$last_hidden_pad = -1;
			
			$add = '';
			for ($i=0; $i<$cur; $i++)
				$add .= ' ';
			
			if ($cur > $pad_count)
				$result .= $add . '<optgroup label="'. $last_item .' Sub :"></optgroup>' . $lnbr;
			
			$pad_count = $cur;
			$last_item = str_replace('_', '', $val);
			
			for ($i=0,$c=($pad_count * 4); $i<$c; $i++)
				$last_item = '&nbsp;' . $last_item;
			
			$selected = ($params['current'] == $key) ? ' selected' : '';
			$result .= $add . '<option value="'. $key .'"'. $selected .'>' . $last_item . '</option>' . $lnbr;
		}
		
		$result .= '</select>' . $lnbr . $lnbr;
		
		return $result;
	}

	private function getLabelSpace($count)
	{
		$result = '';
		for ($i=0; $i<$count; $i++)
			$result .= '&nbsp;';
		return $result;
	}
}

?>