<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Notification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->string('target')->nullable();
            $table->text('fcm_response')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('notification_sents', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('notification_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('push_token')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamp('read_at')->nullable();
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
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('notification_sents');
    }
}
