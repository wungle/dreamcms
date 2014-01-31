<?php
App::uses('Configure', 'Core');
App::uses('ClassRegistry', 'Utility');
App::uses('Set', 'Utility');
App::uses('Security', 'Utility');
App::uses('AclComponent', 'Controller/Component');

App::uses('Admin', 'Dreamcms.Model');
App::uses('CmsMenu', 'Dreamcms.Model');
App::uses('Group', 'Dreamcms.Model');

App::uses('Photo', 'PhotoGalleries.Model');
App::uses('PhotoAlbum', 'PhotoGalleries.Model');
App::uses('PhotoAlbumI18n', 'PhotoGalleries.Model');
App::uses('PhotoI18n', 'PhotoGalleries.Model');
App::uses('PhotoThumbnail', 'PhotoGalleries.Model');

class DataGenerator
{

	public function __construct() {
		Configure::write('Cache.disable', true);
		Configure::write('App.SchemaCreate', true);
	}

	public function run() {
		$this->initPhoto();
		$this->initPhotoAlbum();
		$this->initPhotoAlbumI18n();
		$this->initPhotoI18n();
		$this->initPhotoThumbnail();

		$this->initCmsMenu();
		$this->initArosAcos();

		echo 'You need to clear your app cache after creating the schema, in /app/tmp/cache.' . "\n\n";
	}

	protected function initPhoto() {
		try {
			$photo = ClassRegistry::init('PhotoGalleries.Photo');

			if (method_exists($photo, 'destroyCache') && is_subclass_of($photo, 'CacheableModel'))
				@$photo->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initPhotoAlbum() {
		try {
			$photo_album = ClassRegistry::init('PhotoGalleries.PhotoAlbum');

			if (method_exists($photo_album, 'destroyCache') && is_subclass_of($photo_album, 'CacheableModel'))
				@$photo_album->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initPhotoAlbumI18n() {
		try {
			$photo_album_i18n = ClassRegistry::init('PhotoGalleries.PhotoAlbumI18n');

			if (method_exists($photo_album_i18n, 'destroyCache') && is_subclass_of($photo_album_i18n, 'CacheableModel'))
				@$photo_album_i18n->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initPhotoI18n() {
		try {
			$photo_i18n = ClassRegistry::init('PhotoGalleries.PhotoI18n');

			if (method_exists($photo_i18n, 'destroyCache') && is_subclass_of($photo_i18n, 'CacheableModel'))
				@$photo_i18n->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initPhotoThumbnail() {
		try {
			$photo_thumbnail = ClassRegistry::init('PhotoGalleries.PhotoThumbnail');

			if (method_exists($photo_thumbnail, 'destroyCache') && is_subclass_of($photo_thumbnail, 'CacheableModel'))
				@$photo_thumbnail->destroyCache();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}

	protected function initCmsMenu() {
		try {
			$cms_menu = ClassRegistry::init('Dreamcms.CmsMenu');
			$photos = $cms_menu->find(
				'first',
				array(
					'conditions' => array(
						'CmsMenu.url' => '/dreamcms/photo_galleries/photos',
						'CmsMenu.published' => 'Yes',
						'CmsMenu.deleted' => '0'
					)
				)
			);
			if (!$photos)
			{
				$cms_menu->create();
				$cms_menu->save(array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-picture',
							'name' => 'Photos',
							'url' => '/dreamcms/photo_galleries/photos',
						),
						$this->getDefaultValues()
					)
				));
			}

			$photo_albums = $cms_menu->find(
				'first',
				array(
					'conditions' => array(
						'CmsMenu.url' => '/dreamcms/photo_galleries/photo_albums',
						'CmsMenu.published' => 'Yes',
						'CmsMenu.deleted' => '0'
					)
				)
			);
			if (!$photo_albums)
			{
				$cms_menu->create();
				$cms_menu->save(array(
					'CmsMenu' => Set::merge(
						array(
							'parent_id' => '1',
							'icon' => 'icon-picture',
							'name' => 'Photo Albums',
							'url' => '/dreamcms/photo_galleries/photo_albums',
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
							'/dreamcms/photo_galleries/photo_albums',
							'/dreamcms/photo_galleries/photos',
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