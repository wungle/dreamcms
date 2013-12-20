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
				'Admin' => array(
					'admin_id' => 0,
					'fullname' => 'Super Admin',
					'username' => 'superadmin',
					'password' => '',
					'email' => 'richan.fongdasen@yahoo.com'
				)
			);

		return parent::authenticate($request, $response);
	}
}

?>