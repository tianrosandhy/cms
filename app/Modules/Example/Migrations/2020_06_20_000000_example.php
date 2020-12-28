<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Example extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('examples', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text')->nullable();
            $table->integer('number')->nullable();
            $table->date('dates')->nullable();
            $table->string('daterange')->nullable();
            $table->string('select')->nullable();
            $table->string('select_multiple')->nullable();
            $table->text('textarea')->nullable();
            $table->text('richtext')->nullable();
            $table->text('image')->nullable();
            $table->text('image_multiple')->nullable();
            $table->text('file')->nullable();
            $table->text('file_multiple')->nullable();
            $table->string('radio')->nullable();
            $table->string('checkbox')->nullable();
            $table->string('yesno')->nullable();
            $table->text('map')->nullable();
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
        Schema::dropIfExists('examples');
    }
}
