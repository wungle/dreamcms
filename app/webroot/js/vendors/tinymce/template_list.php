<?php

function get_webroot()
{
	$path = dirname(__FILE__);
	$path = explode(DIRECTORY_SEPARATOR, $path);
	$i = count($path)-1;
	unset($path[$i]);
	
	return implode(DIRECTORY_SEPARATOR, $path);
}

function extract_file_ext( $filename )
{
	$info = pathinfo($filename);
	if (!empty($info) && !empty($info['extension']))
		return $info['extension'];
	else
		return false;
}

function generate_template_name($name)
{
	$name = str_replace("-", " ", $name);
	$name = str_replace("_", " ", $name);
	$name = str_replace(".html", "", $name);
	
	$after_space = true;
	$result = "";
	
	for ($i=0,$c=strlen($name); $i<$c; $i++)
	{
		$result .= ($after_space) ? strtoupper($name{$i}) : $name{$i};
		$after_space = ($name{$i} == " ") ? true : false;
	}
	
	return $result;
}

function read_template_dir($dir)
{
	$templates = array();
	$handle = opendir($dir);
	if ($handle)
	{
		while ( ($file = readdir($handle)) !== false )
		{
			if ( ($file != ".") && ($file != "..") && is_file($dir . DIRECTORY_SEPARATOR . $file) && (extract_file_ext($file) == "html") )
			{
				$templates[$file] = array(
					"name" => generate_template_name($file),
					"url" => "/files/templates/" . $file,
					"description" => generate_template_name($file)
				);
			}
		}
	}
	closedir($handle);
	
	ksort($templates);
	return $templates;
}

$templates = read_template_dir(get_webroot() . "/files/templates");
?>
/*
 ***************************************************************************************************
 *
 *  AUTO GENERATED TEMPLATE LIST
 *
 ***************************************************************************************************
*/
var tinyMCETemplateList = [
	// Name, URL, Description
<?php

	$i = 0;
	$c = count($templates);
	foreach ($templates as $template)
	{
		echo ($i<$c-1) ?
			chr(9) . "[\"{$template['name']}\", \"{$template['url']}\", \"{$template['description']}\"],\n" :
			chr(9) . "[\"{$template['name']}\", \"{$template['url']}\", \"{$template['description']}\"]\n";
		$i++;
	}

?>
];