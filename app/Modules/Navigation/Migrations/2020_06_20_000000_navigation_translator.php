<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NavigationTranslator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigation_item_translators', function($table){
            $table->increments('id');
            $table->integer('main_id')->nullable();
            $table->string('lang')->nullable();
            $table->integer('group_id');
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->text('url')->nullable();
            $table->string('route')->nullable();
            $table->string('slug')->nullable();
            $table->string('icon')->nullable();
            $table->tinyinteger('new_tab')->nullable();
            $table->integer('sort_no')->nullable();
            $table->integer('parent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('navigation_item_translators');
    }
}
