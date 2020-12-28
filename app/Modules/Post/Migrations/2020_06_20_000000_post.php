<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Post extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('author')->nullable();
            $table->integer('category_id')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
