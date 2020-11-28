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
##### Module Scaffolding
You can create module easily with this command : 
```sh
$ php artisan autocrud:module
```
after that, type the module name that you want to create. Ex : "ModuleExample". Then, you need to register the new service provider in config (config/modules.php) :
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

##### Migration Update
In every "modules/ModuleName" directory, there is "Extenders" called "MigrationModifier". This file is useful when you already migrate some table, and you need to change, add column, or drop column the migrated table. This class method is look like migration structure with some improvement.
```php
<?php
namespace App\Modules\ModuleName\Extenders;

use App\Core\Components\DatabaseStructureModifier;

class MigrationModifier extends DatabaseStructureModifier
{
	public function handle(){
        $this->handleTable('tablename', function($table){
            $table->integer('field_name')->nullable(); //add column
            $table->string('field_name')->nullable()->change(); //modify column
            $table->dropColumn('field_name'); //drop column
        });
	}
}
```
To apply these migration modifier, you need to run the command 
```sh
$ php artisan autocrud:migration-update
```
This command is safe for multiple calling. If the database structure already handled before and return exception, then it will be ignored.
