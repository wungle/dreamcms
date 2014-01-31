DreamCMS
========

DreamCMS is a powerful content management system (CMS) with a charming GUI, a lot of feature and multi themes available - based on CakePHP framework.


Here is the list of features currently available in DreamCMS:

* Admins & Admin Groups management
* CMS Menu management
* Files & File Types management
* Languages management
* Photos & Photo Albums management
* Thumbnail Types management
* Web Settings / Configurations
* Web Menu management

Key Features :
--------------
* Support Multi Languages
* Embedded ACL (Access Control List)
* Routable feature for : File Types, Files, Photo Albums, Photos, and Web Menu
* Uploadable Behavior
* Thumbnailable Behavior
* Logable Behavior
* Cacheable Model

---------------------------------------


Installation Guide
------------------
* Clone this repository

* copy the `app/Config/core.php.default` file to `app/Config/core.php`

* create your own database config : `app/Config/database.php`

* copy the `app/Model/AppModel.php.default` file to `app/Model/AppModel.php`

* copy the `app/Controller/AppController.php.default` file to `app/Controller/AppController.php`

* copy the `app/Plugin/Dreamcms/Config/routes.php.default` file to `app/Plugin/Dreamcms/Config/routes.php`

* Please make sure your temporary directory is writable: `chmod -R 0777 app/tmp`

* Well done, you're ready to go now !!


---------------------------------------

Database Installation for Core DreamCMS
---------------------------------------
```sh
$ cd app/Console
$ ./cake schema create --name Dreamcms.Default
```

Database Installation for Photo Galleries
-----------------------------------------
```sh
$ cd app/Console
$ ./cake schema create --name PhotoGalleries.Default
```

---------------------------------------

Default DreamCMS Login
----------------------
URL: http://your-dreamcms-installation-path/secret/login

Username: admin

Password: admin123

---------------------------------------


CakePHP Bake Tutorial
---------------------
```sh
$ cd app/Console 
$ ./cake bake plugin PluginNameInCamelCase 
$ ./cake bake controller --plugin PluginNameInCamelCase 
$ ./cake bake model --plugin PluginNameInCamelCase 
$ ./cake bake view --plugin PluginNameInCamelCase 
```

---------------------------------------