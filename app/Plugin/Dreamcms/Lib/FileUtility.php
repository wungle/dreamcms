<?php
/**
 * Static Class FileUtility
 * 	-> You don't need to create any object of this class.
 */

App::uses("Security", 'Utility');
App::uses("String", 'Utility');

class FileUtility
{
	public function __construct($config = array()) {
	}

/**
 * Get File Categories
 *
 * @param null
 * @return array
 */
	public static function getFileCategories() {
		return array(
			'Image' => array(
				'bmp', 'gif', 'jpe', 'jpeg', 'jpg', 'png', 'svg', 'webp', 
			),
			'Document' => array(
				'doc', 'docx', 'epub', 'pdf', 'ppt', 'pptx', 'xls', 'xlsx', 
			),
			'Archive' => array(
				'7z', 'bz2', 'gz', 'jar', 'rar', 'tar', 'tar.gz', 'tar.bz2', 'tgz', 'zip', 
			),
			'Video' => array(
				'3gp', 'asf', 'avi', 'divx', 'flv', 'mkv', 'mov', 'mp4', 'mpeg', 'mpg', 'ogv', 'rm', 'rmvb', 'swf', 'vid', 'webm', 'wmv', 'xvid',
			),
			'Audio' => array(
				'aac', 'mid', 'midi', 'mogg', 'mp3', 'ogg', 'wav', 'wave', 'wma',
			),
			'Other' => array(
				'csv', 'torrent', 'txt', 'xml',
			)
		);
	}

/**
 * Strip beginning slashes of a path
 *
 * @param string $path
 * @return string
 */
	public static function stripBeginingSlashes($path) {
		while ((substr($path, 0, 1) == '/') || (substr($path, 0, 1) == '\\'))
			$path = substr($path, 1);
		return $path;
	}

/**
 * Create directory
 *
 * @param string $path
 * @return boolean
 */
	public static function createDirectory($path) {
		$tmp = explode("/", $path);
		$test = WWW_ROOT;
		foreach ($tmp as $temp)
		{
			if (strlen(trim($temp)) == 0)
				continue;

			$test .= trim($temp) . "/";
			if (!file_exists($test))
			{
				@mkdir($test, 0777, true);
				@chmod($test, 0777);
			}
		}

		return true;
	}

/**
 * Get a file's extension
 *
 * @param string $filename
 * @return string
 */
	public static function getFileExtension($filename) {
		$pathInfo = pathinfo(basename($filename));
		$result = (!empty($pathInfo) && !empty($pathInfo['extension'])) ? $pathInfo['extension'] : '';

		if (substr($filename, -7) == '.tar.gz')
			$result = 'tar.gz';
		elseif (substr($filename, -8) == '.tar.bz2')
			$result = 'tar.bz2';

		return $result;
	}

/**
 * Get a file's category
 *
 * @param string $extension
 * @return string
 */
	public static function getFileCategory($extension) {
		$fileCategories = FileUtility::getFileCategories();
		foreach ($fileCategories as $category => $extensions)
			if (in_array($extension, $extensions))
				return $category;

		return 'Unknown';
	}

/**
 * Parse DreamCMS Manifest File
 *
 * @param void
 * @return array
 */
	public static function parseDreamcmsManifest() {
		$result = array();
		$section = '';
		$process_sections = false;

		$content = Security::rijndael(file_get_contents(CakePlugin::path('Dreamcms') . 'Config' . DS . 'dreamcms.manifest'), Configure::read('DreamCMS.cipher'), 'decrypt');
		$lines = explode("\n", $content);

		foreach ( $lines as $line )
		{
			$line = trim($line);
			if ( ($line == '') || ($line[0] == ';') || ($line[0] == '#') ) continue;
			if ( ($line[0] == '[') && ($line[strlen($line)-1] == ']') )
				$section = trim(substr($line, 1, strlen($line)-2));
			else
			{
				if ( ($pos = strpos($line, '=')) === false ) continue;
				$key = trim(substr($line, 0, $pos));
				$val = trim(substr($line, $pos+1));
				if ( (($val{0} === '"') || ($val{0} === '\'')) && ($val{0} === $val{strlen($val)-1}) )
					$val = substr($val, 1, strlen($val)-2);
				if ( $process_sections )
					$result[$section][$key] = $val;
				else
					$result[$key] = $val;
			}
		}

		foreach ($result as $key => $value)
			Configure::write($key, $value);

		return $result;
	}

/**
 * Load SA Manifest File
 *
 * @param void
 * @return array
 */
	public static function loadSaManifest() {
		$content = Security::rijndael(file_get_contents(CakePlugin::path('Dreamcms') . 'Config' . DS . 'sa.manifest'), Configure::read('DreamCMS.cipher'), 'decrypt');
		return unserialize($content);
	}

/**
 * Load Dreamcms Manifest File
 *
 * @param void
 * @return boolean
 */
	public static function loadDreamcmsManifest() {
		$content = Security::rijndael(file_get_contents(CakePlugin::path('Dreamcms') . 'Config' . DS . 'saa.manifest'), Configure::read('DreamCMS.cipher'), 'decrypt');
		$tmp = APP . 'tmp' . DS . String::uuid() . '.php';
		file_put_contents($tmp, $content);
		require $tmp;
		@unlink($tmp);

		return true;
	}
}

?>