# Laravel AutoCRUD CMS Generator
---
### Installation
First you need to install just like default laravel (but with tianrosandhy/autocrud-laravel)
```sh
$ composer create-project tianrosandhy/autocrud-laravel
$ composer install
$ cp .env.example .env
$ php artisan key:generate
```
then setup .env with correct database connection & base APP_URL 
```sh
$ php artisan migrate
$ php artisan storage:link
```
Last, open via browser for initial setup (superadmin account), then after setup finish, you can open CMS in {base_url}/p4n3lb04rd to access the CMS

### Available Command

##### Generate Superadmin
You must run this command first to activate the CMS : 
```sh
php artisan autocrud:superadmin
```
This command will guide you to create an initial superadmin account that have all access in CMS. 

##### Module Scaffolding
You can create module easily with this command : 
```sh
$ php artisan autocrud:module {Module Name}
```
```sh
$ php artisan autocrud:blankmodule {Module Name}
```
Note : module name will be generated in PascalCase without space.

autocrud:module is to generate a full auto crud, and autocrud:blankmodule is to generate a module basic scaffolding without autocrud. Blank module is useful when you want to create a really customized module without AutoCRUD scaffolding. Then, you need to register the new module's service provider to config (config/modules.php) :
```php
<?php
//config/modules.php
return [
	'load' => [
		'\App\Modules\ModuleExample\Providers\ModuleExampleServiceProvider',
	],
];
```
After that, you will be able to manage the module in "app/Modules/ModuleExample" for mor customization.

##### Submodule scaffolding
You can create a submodule easily with this command : 
```sh
$ php artisan autocrud:submodule {Module Target} {Sub Module Name}
```
```sh
$ php artisan autocrud:blanksubmodule {Module Target} {Sub Module Name}
```
Note : {Module Target} must be a valid and exists module name. Sub module name will be generated in PascalCase without space.

Same as module scaffolding, but this command will generate a scaffolding in a existing module. So you can group a bunch of module that have a same purpose.


