<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotifiableTable extends Migration {

	public function up()
	{
		Schema::create('notifiable', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('notification_id')->unsigned();
			$table->integer('model_id')->unsigned();
			$table->integer('model_type');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('notifiable');
	}
}