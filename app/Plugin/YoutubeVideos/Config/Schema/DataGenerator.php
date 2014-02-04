<?php
App::uses('Configure', 'Core');
App::uses('ClassRegistry', 'Utility');
App::uses('Set', 'Utility');
App::uses('Security', 'Utility');
App::uses('AclComponent', 'Controller/Component');

App::uses('Admin', 'Dreamcms.Model');
App::uses('CmsMenu', 'Dreamcms.Model');
App::uses('Group', 'Dreamcms.Model');

App::uses('Video', 'YoutubeVideos.Model');
App::uses('VideoAlbum', 'YoutubeVideos.Model');
App::uses('VideoAlbumI18n', 'YoutubeVideos.Model');
App::uses('VideoI18n', 'YoutubeVideos.Model');
App::uses('VideoThumbnail', 'YoutubeVideos.Model');

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

	public function run() {
		$this->initVideo();
		$this->initVideoAlbum();
		$this->initVideoAlbumI18n();
		$this->initVideoI18n();
		$this->initVideoThumbnail();

		$this->initCmsMenu();
		$this->initArosAcos();

		echo 'You need to clear your app cache after creating the schema, in /app/tmp/cache.' . "\n\n";
	}

	protected function initVideo() {
		try {
			$video = ClassRegistry::init('YoutubeVideos.Video');

			if (method_exists($video, 'destroyCache') && is_subclass_of($video, 'CacheableModel'))
				@$video->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initVideoAlbum() {
		try {
			$video_album = ClassRegistry::init('YoutubeVideos.VideoAlbum');

			if (method_exists($video_album, 'destroyCache') && is_subclass_of($video_album, 'CacheableModel'))
				@$video_album->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initVideoAlbumI18n() {
		try {
			$video_album_i18n = ClassRegistry::init('YoutubeVideos.VideoAlbumI18n');

			if (method_exists($video_album_i18n, 'destroyCache') && is_subclass_of($video_album_i18n, 'CacheableModel'))
				@$video_album_i18n->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initVideoI18n() {
		try {
			$video_i18n = ClassRegistry::init('YoutubeVideos.VideoI18n');

			if (method_exists($video_i18n, 'destroyCache') && is_subclass_of($video_i18n, 'CacheableModel'))
				@$video_i18n->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initVideoThumbnail() {
		try {
			$video_thumbnail = ClassRegistry::init('YoutubeVideos.VideoThumbnail');

			if (method_exists($video_thumbnail, 'destroyCache') && is_subclass_of($video_thumbnail, 'CacheableModel'))
				@$video_thumbnail->destroyCache();
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
			$videos = $cms_menu->find(
				'first',
				array(
					'conditions' => array(
						'CmsMenu.url' => '/dreamcms/youtube_videos/videos',
						'CmsMenu.published' => 'Yes',
						'CmsMenu.deleted' => '0'
					)
				)
			);
			if (!$videos)
			{
				$cms_menu->create();
				$cms_menu->save(array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-youtube-play',
							'name' => 'Videos',
							'url' => '/dreamcms/youtube_videos/videos',
						),
						$this->getDefaultValues()
					)
				));
			}

			$video_albums = $cms_menu->find(
				'first',
				array(
					'conditions' => array(
						'CmsMenu.url' => '/dreamcms/youtube_videos/video_albums',
						'CmsMenu.published' => 'Yes',
						'CmsMenu.deleted' => '0'
					)
				)
			);
			if (!$video_albums)
			{
				$cms_menu->create();
				$cms_menu->save(array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-youtube-play',
							'name' => 'Video Albums',
							'url' => '/dreamcms/youtube_videos/video_albums',
						),
						$this->getDefaultValues()
					)
				));
			}
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initArosAcos() {
		try {
			$cms_menu = ClassRegistry::init('Dreamcms.CmsMenu');
			$Aro = ClassRegistry::init('Aro');
			$Aco = ClassRegistry::init('Aco');
			$ArosAco = ClassRegistry::init('ArosAco');

			$cms_menus = $cms_menu->find(
				'list',
				array(
					'fields' => array('CmsMenu.id', 'CmsMenu.id'),
					'conditions' => array(
						'CmsMenu.published' => 'Yes',
						'CmsMenu.deleted' => '0',
						'CmsMenu.url' => array(
							'/dreamcms/youtube_videos/video_albums',
							'/dreamcms/youtube_videos/videos',
						)
					)
				)
			);
			sort($cms_menus);

			$aros = $Aro->find('all');
			$acos = $Aco->find(
				'all',
				array(
					'conditions' => array(
						'model' => 'CmsMenu',
						'foreign_key' => $cms_menus
					)
				)
			);
			
			foreach ($aros as $aro)
			{
				foreach ($acos as $aco)
				{
					$aros_acos = $ArosAco->find(
						'first',
						array(
							'conditions' => array(
								'aro_id' => $aro['Aro']['id'],
								'aco_id' => $aco['Aco']['id'],
							),
							'limit' => 1
						)
					);

					if (!$aros_acos)
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