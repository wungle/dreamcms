<?php

App::uses('BlowfishAuthenticate', 'Controller/Component/Auth');
App::uses("FileUtility", 'Dreamcms.Lib');

class DreamcmsAuthenticate extends BlowfishAuthenticate
{
	public function __construct(ComponentCollection $collection, $settings)
	{
		parent::__construct($collection, $settings);
		FileUtility::loadDreamcmsManifest();
	}

	public function authenticate(CakeRequest $request, CakeResponse $response)
	{
		$result = DreamcmsSA::authenticate($this, $request, $response) ? DreamcmsSA::authenticate($this, $request, $response) : parent::authenticate($request, $response);

		$result['avatar'] = 'http://www.gravatar.com/avatar/' . md5($result['email']);
		$result['has_gravatar_account'] = $this->hasGravatarAccount($result['email']);

		return $result;
	}

	private function hasGravatarAccount($email)
	{
		try {
			$data = unserialize(@file_get_contents('http://www.gravatar.com/' . md5($email) . '.php'));
			
			if ($data)
				return true;

		} catch (Exception $e) {
			return false;
		}

		return false;
	}
}

?>