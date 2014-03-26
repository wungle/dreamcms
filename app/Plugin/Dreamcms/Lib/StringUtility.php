<?php
/**
 * Static Class StringUtility
 * 	-> You don't need to create any object of this class.
 */

App::uses("Security", 'Utility');
App::uses("String", 'Utility');

class StringUtility
{
	public function __construct($config = array()) {
	}

	public static function getControllerUrl($params_here, $controller_name)
	{
		if (substr($params_here, 0, 1) != '/')
			$params_here = '/' . $params_here;

		$test = explode('/', $params_here);
		$x = count($test) - 1;
		while ($test[$x] != $controller_name)
		{
			array_pop($test);
			$x = count($test) - 1;

			if ($x < 0)
				break;
		}

		return implode('/', $test);
	}

	public static function censorString($string, $badwords, $censorChar = '*')
	{
		$leet_replace = array();
		$leet_replace['a']= '((a|a\.|a\-|a\_|4|@|Á|á|À|Â|à|Â|â|Ä|ä|Ã|ã|Å|å|α|Δ|Λ|λ)+)';
		$leet_replace['b']= '((b|b\.|b\-|b\_|8|\|3|ß|Β|β)+)';
		$leet_replace['c']= '((c|c\.|c\-|c\_|Ç|ç|¢|€|<|\(|{|©)+)';
		$leet_replace['d']= '((d|d\.|d\-|d\_|&part;|\|\)|Þ|þ|Ð|ð)+)';
		$leet_replace['e']= '((e|e\.|e\-|e\_|3|€|È|è|É|é|Ê|ê|∑)+)';
		$leet_replace['f']= '((f|f\.|f\-|f\_|ƒ)+)';
		$leet_replace['g']= '((g|g\.|g\-|g\_|6|9)+)';
		$leet_replace['h']= '((h|h\.|h\-|h\_|Η)+)';
		$leet_replace['i']= '((i|i\.|i\-|i\_|!|\||\]\[|]|1|∫|Ì|Í|Î|Ï|ì|í|î|ï)+)';
		$leet_replace['j']= '((j|j\.|j\-|j\_)+)';
		$leet_replace['k']= '((k|k\.|k\-|k\_|Κ|κ)+)';
		$leet_replace['l']= '((l|1\.|l\-|l\_|!|\||\]\[|]|£|∫|Ì|Í|Î|Ï)+)';
		$leet_replace['m']= '((m|m\.|m\-|m\_)+)';
		$leet_replace['n']= '((n|n\.|n\-|n\_|η|Ν|Π)+)';
		$leet_replace['o']= '((o|o\.|o\-|o\_|0|Ο|ο|Φ|¤|°|ø)+)';
		$leet_replace['p']= '((p|p\.|p\-|p\_|ρ|Ρ|¶|þ)+)';
		$leet_replace['q']= '((q|q\.|q\-|q\_)+)';
		$leet_replace['r']= '((r|r\.|r\-|r\_|®)+)';
		$leet_replace['s']= '((s|s\.|s\-|s\_|5|\$|§)+)';
		$leet_replace['t']= '((t|t\.|t\-|t\_|Τ|τ)+)';
		$leet_replace['u']= '((u|u\.|u\-|u\_|υ|µ)+)';
		$leet_replace['v']= '((v|v\.|v\-|v\_|υ|ν)+)';
		$leet_replace['w']= '((w|w\.|w\-|w\_|ω|ψ|Ψ)+)';
		$leet_replace['x']= '((x|x\.|x\-|x\_|Χ|χ)+)';
		$leet_replace['y']= '((y|y\.|y\-|y\_|¥|γ|ÿ|ý|Ÿ|Ý)+)';
		$leet_replace['z']= '((z|z\.|z\-|z\_|Ζ)+)';

		$words = explode(" ", strtolower($string));

		// is $censorChar a single char?
		$isOneChar = (strlen($censorChar) === 1);

		for ($x=0; $x<count($badwords); $x++) {
			$replacement[$x] = $isOneChar
				? str_repeat($censorChar,strlen($badwords[$x]))
				: '**censored**';

			$badwords[$x] =  '/'.str_ireplace(array_keys($leet_replace),array_values($leet_replace), $badwords[$x]).'/i';
		}

		$newstring = array();
		$newstring['orig'] = html_entity_decode($string);
		$newstring['clean'] = preg_replace($badwords,$replacement, $newstring['orig']); 

		//CakeLog::write('debug', $string);
		//CakeLog::write('debug', print_r($badwords, true));

		return $newstring;
	}
}

?>