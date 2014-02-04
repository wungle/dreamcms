<?php
App::uses('Configure', 'Core');
App::uses('ClassRegistry', 'Utility');
App::uses('Set', 'Utility');
App::uses('Security', 'Utility');
App::uses('AclComponent', 'Controller/Component');

App::uses('DreamcmsAppModel', 'Dreamcms.Model');
App::uses('CacheableModel', 'Dreamcms.Model');
App::uses('Admin', 'Dreamcms.Model');
App::uses('CmsMenu', 'Dreamcms.Model');
App::uses('FileI18n', 'Dreamcms.Model');
App::uses('FileType', 'Dreamcms.Model');
App::uses('Files', 'Dreamcms.Model');
App::uses('Group', 'Dreamcms.Model');
App::uses('Icon', 'Dreamcms.Model');
App::uses('Language', 'Dreamcms.Model');
App::uses('Setting', 'Dreamcms.Model');
App::uses('TempDir', 'Dreamcms.Model');
App::uses('Thumbnail', 'Dreamcms.Model');
App::uses('ThumbnailType', 'Dreamcms.Model');
App::uses('WebMenu', 'Dreamcms.Model');
App::uses('WebMenuI18n', 'Dreamcms.Model');

class DataGenerator
{
	public function __construct() {
		Configure::write('Cache.disable', true);
		Configure::write('App.SchemaCreate', true);
		Configure::write('DreamCMS.logable.custom_admin', array(
			'group_id' => '0',
			'username' => 'system',
			'real_name' => 'System Installer',
			'email' => 'richan.fongdasen@yahoo.com',
			'last_login' => '0000-00-00 00:00:00',
			'last_login_ip' => '0.0.0.0',
			'active' => 'Yes',
			'deleted' => '0',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
		));
	}

	public function run()
	{
		$this->initFileI18n();
		$this->initFileType();
		$this->initFiles();
		$this->initTempDir();
		$this->initThumbnail();
		$this->initThumbnailType();
		$this->initThumbnailType();
		$this->initWebMenu();
		$this->initWebMenuI18n();

		$this->initSetting();
		$this->initLanguage();
		$this->initIcon();

		$this->initGroup();
		$this->initAdmin();
		$this->initCmsMenu();

		$this->initArosAcos();

		echo 'You need to clear your app cache after creating the schema, in /app/tmp/cache.' . "\n\n";
	}

	protected function initAdmin() {
		try {
			Configure::write('DreamCMS.Routeable.current_controller', 'admins');
			Configure::write('App.params_here', '/dreamcms/admins/add');

			$admin = ClassRegistry::init(array('class' => 'Dreamcms.Admin', 'alias' => 'DreamcmsAdmin'), true);

			if (method_exists($admin, 'destroyCache') && is_subclass_of($admin, 'CacheableModel'))
				@$admin->destroyCache();
			
			$admin->create();
			$admin->save(array(
				'DreamcmsAdmin' => Set::merge(
					array(
						'group_id' => '1',
						'username' => 'admin',
						'password' => 'admin123',
						'real_name' => 'Administrator',
						'email' => 'admin@admin.com',
					),
					$this->getDefaultValues()
				)
			));
			unset($admin);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initCmsMenu() {
		try {
			Configure::write('DreamCMS.Routeable.current_controller', 'cms_menus');
			Configure::write('App.params_here', '/dreamcms/cms_menus/add');

			$cms_menu = ClassRegistry::init('Dreamcms.CmsMenu');

			if (method_exists($cms_menu, 'destroyCache') && is_subclass_of($cms_menu, 'CacheableModel'))
				@$cms_menu->destroyCache();

			$cms_menu->create();
			$cms_menu->saveMany(array(
				array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '0',
							'icon' => 'icon-linux',
							'name' => 'Core',
							'url' => '#',
						),
						$this->getDefaultValues()
					)
				),
				array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-user',
							'name' => 'Admins',
							'url' => '/dreamcms/admins',
						),
						$this->getDefaultValues()
					)
				),
				array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-align-justify',
							'name' => 'CMS Menus',
							'url' => '/dreamcms/cms_menus',
						),
						$this->getDefaultValues()
					)
				),
				array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-file',
							'name' => 'File Types',
							'url' => '/dreamcms/file_types',
						),
						$this->getDefaultValues()
					)
				),
				array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-file',
							'name' => 'Files',
							'url' => '/dreamcms/files',
						),
						$this->getDefaultValues()
					)
				),
				array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-group',
							'name' => 'Groups',
							'url' => '/dreamcms/groups',
						),
						$this->getDefaultValues()
					)
				),
				array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-flag',
							'name' => 'Languages',
							'url' => '/dreamcms/languages',
						),
						$this->getDefaultValues()
					)
				),
				array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-gears',
							'name' => 'Settings',
							'url' => '/dreamcms/settings',
						),
						$this->getDefaultValues()
					)
				),
				array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-folder-open',
							'name' => 'Temporary Dirs',
							'url' => '/dreamcms/temp_dirs',
						),
						$this->getDefaultValues()
					)
				),
				array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-picture',
							'name' => 'Thumbnail Types',
							'url' => '/dreamcms/thumbnail_types',
						),
						$this->getDefaultValues()
					)
				),
				array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-align-justify',
							'name' => 'Web Menus',
							'url' => '/dreamcms/web_menus',
						),
						$this->getDefaultValues()
					)
				),
			));
			unset($cms_menu);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initFileI18n() {
		try {
			$file_i18n = ClassRegistry::init('Dreamcms.FileI18n');

			if (method_exists($file_i18n, 'destroyCache') && is_subclass_of($file_i18n, 'CacheableModel'))
				@$file_i18n->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initFileType() {
		try {
			$file_type = ClassRegistry::init('Dreamcms.FileType');

			if (method_exists($file_type, 'destroyCache') && is_subclass_of($file_type, 'CacheableModel'))
				@$file_type->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initFiles() {
		try {
			$files = ClassRegistry::init('Dreamcms.Files');

			if (method_exists($files, 'destroyCache') && is_subclass_of($files, 'CacheableModel'))
				@$files->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initGroup() {
		try {
			Configure::write('DreamCMS.Routeable.current_controller', 'groups');
			Configure::write('App.params_here', '/dreamcms/groups/add');

			$group = ClassRegistry::init('Dreamcms.Group');

			if (method_exists($group, 'destroyCache') && is_subclass_of($group, 'CacheableModel'))
				@$group->destroyCache();

			$group->create();
			$group->save(array(
				'Group' => Set::merge(
					array(
						'name' => 'Super Administrator'
					),
					$this->getDefaultValues()
				)
			));
			unset($group);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initIcon() {
		try {
			$icons = json_decode(file_get_contents(dirname(__FILE__) . DS . 'font-awesome-3.2.1.json'));
			//$icons = json_decode(file_get_contents(dirname(__FILE__) . DS . 'font-awesome-4.0.3.json'));

			$icon = ClassRegistry::init('Dreamcms.Icon');

			if (method_exists($icon, 'destroyCache') && is_subclass_of($icon, 'CacheableModel'))
				@$icon->destroyCache();

			$icon->create();
			$icon->saveMany($icons);
			unset($icon);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initLanguage() {
		try {
			Configure::write('DreamCMS.Routeable.current_controller', 'languages');
			Configure::write('App.params_here', '/dreamcms/languages/add');

			$language = ClassRegistry::init('Dreamcms.Language');

			if (method_exists($language, 'destroyCache') && is_subclass_of($language, 'CacheableModel'))
				@$language->destroyCache();

			$language->create();
			$language->save(array(
				'Language' => Set::merge(
					array(
						'name' => 'English',
						'locale' => 'en-US',
					),
					$this->getDefaultValues()
				)
			));
			unset($language);
		} catch (Exception $e) {
			return false;
		}
	}

	protected function initSetting() {
		try {
			Configure::write('DreamCMS.Routeable.current_controller', 'settings');
			Configure::write('App.params_here', '/dreamcms/settings/add');

			$setting = ClassRegistry::init('Dreamcms.Setting');

			if (method_exists($setting, 'destroyCache') && is_subclass_of($setting, 'CacheableModel'))
				@$setting->destroyCache();

			$setting->create();
			$setting->saveMany(array(
				array(
					'Setting' => Set::merge(
						array(
							'name' => 'web_name',
							'value' => 'DreamCMS'
						),
						$this->getDefaultValues()
					)
				),
				array(
					'Setting' => Set::merge(
						array(
							'name' => 'web_url',
							'value' => 'http://localhost/'
						),
						$this->getDefaultValues()
					)
				),
				array(
					'Setting' => Set::merge(
						array(
							'name' => 'admin_emails',
							'value' => 'richan.fongdasen@yahoo.com'
						),
						$this->getDefaultValues()
					)
				),
				array(
					'Setting' => Set::merge(
						array(
							'name' => 'web_css',
							'value' => 'default.css'
						),
						$this->getDefaultValues()
					)
				),
				array(
					'Setting' => Set::merge(
						array(
							'name' => 'default_language',
							'value' => 'en-US'
						),
						$this->getDefaultValues()
					)
				),
				array(
					'Setting' => Set::merge(
						array(
							'name' => 'debug_status',
							'value' => 'On'
						),
						$this->getDefaultValues()
					)
				),
				array(
					'Setting' => Set::merge(
						array(
							'name' => 'ga_script_code',
							'value' => "<!-- GOOGLE ANALYTICS START -->\n\n\n<!-- GOOGLE ANALYTICS END -->"
						),
						$this->getDefaultValues()
					)
				),
				array(
					'Setting' => Set::merge(
						array(
							'name' => 'recaptcha_public_key',
							'value' => '6LdNbcESAAAAABhy86e2Gl_SbZ5i_gJtXxbUzMHk'
						),
						$this->getDefaultValues()
					)
				),
				array(
					'Setting' => Set::merge(
						array(
							'name' => 'recaptcha_private_key',
							'value' => '6LdNbcESAAAAAHlLk_AGQ9YHURlFxOiVeBeOPAxQ'
						),
						$this->getDefaultValues()
					)
				),
				array(
					'Setting' => Set::merge(
						array(
							'name' => 'facebook_app_id',
							'value' => 'NULL'
						),
						$this->getDefaultValues()
					)
				),
				array(
					'Setting' => Set::merge(
						array(
							'name' => 'facebook_app_secret',
							'value' => 'NULL'
						),
						$this->getDefaultValues()
					)
				),
				array(
					'Setting' => Set::merge(
						array(
							'name' => 'permanent_delete',
							'value' => 'Yes'
						),
						$this->getDefaultValues()
					)
				),
			));
			unset($setting);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initTempDir() {
		try {
			$temp_dir = ClassRegistry::init('Dreamcms.TempDir');

			if (method_exists($temp_dir, 'destroyCache') && is_subclass_of($temp_dir, 'CacheableModel'))
				@$temp_dir->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initThumbnail() {
		try {
			$thumbnail = ClassRegistry::init('Dreamcms.Thumbnail');

			if (method_exists($thumbnail, 'destroyCache') && is_subclass_of($thumbnail, 'CacheableModel'))
				@$thumbnail->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initThumbnailType() {
		try {
			$thumbnail_type = ClassRegistry::init('Dreamcms.ThumbnailType');

			if (method_exists($thumbnail_type, 'destroyCache') && is_subclass_of($thumbnail_type, 'CacheableModel'))
				@$thumbnail_type->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initWebMenu() {
		try {
			$web_menu = ClassRegistry::init('Dreamcms.WebMenu');

			if (method_exists($web_menu, 'destroyCache') && is_subclass_of($web_menu, 'CacheableModel'))
				@$web_menu->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initWebMenuI18n() {
		try {
			$web_menu_i18n = ClassRegistry::init('Dreamcms.WebMenuI18n');

			if (method_exists($web_menu_i18n, 'destroyCache') && is_subclass_of($web_menu_i18n, 'CacheableModel'))
				@$web_menu_i18n->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initArosAcos()
	{
		try {
			$Aro = ClassRegistry::init('Aro');
			$Aco = ClassRegistry::init('Aco');
			$ArosAco = ClassRegistry::init('ArosAco');

			$aros = $Aro->find('all');
			$acos = $Aco->find('all');
			
			foreach ($aros as $aro)
			{
				foreach ($acos as $aco)
				{
					$ArosAco->create();
					$ArosAco->save(array(
						'ArosAco' => array(
							'aro_id' => $aro['Aro']['id'],
							'aco_id' => $aco['Aco']['id'],
							'_create' => '1',
							'_read' => '1',
							'_update' => '1',
							'_delete' => '1',
						)
					));
				}
			}
			
			unset($Aro, $Aco, $ArosAco, $aros, $acos, $aro, $aco);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function getDefaultValues()
	{
		return array(
			'active' => 'Yes',
			'published' => 'Yes',
			'deleted' => '0',
			'created' => '2014-01-01 00:00:00',
			'modified' => '2014-01-01 00:00:00',
		);
	}
}

?>