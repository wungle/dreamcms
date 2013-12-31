<?php
/**
 * Static Class FileUtility
 * 	-> You don't need to create any object of this class.
 */

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
}

?>