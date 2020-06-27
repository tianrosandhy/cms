<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostTranslator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        // must be an exact copy from the table target, but add "main_id" & "lang_code" field
        Schema::create('post_translators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('main_id')->nullable();
            $table->string('lang')->nullable();
            $table->string('title')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('author')->nullable();
            $table->text('description')->nullable();
            $table->string('tags')->nullable();
            $table->string('image')->nullable();
            $table->integer('sort_no')->nullable();
            $table->tinyInteger('is_active')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_translators');
    }
}
