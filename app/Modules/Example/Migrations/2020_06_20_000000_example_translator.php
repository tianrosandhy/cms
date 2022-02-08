<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
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
        Schema::create('example_translators', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('main_id')->nullable();
            $table->string('lang', 50)->nullable();
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

            $table->index('main_id');
            $table->index('lang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('example_translators');
    }
};