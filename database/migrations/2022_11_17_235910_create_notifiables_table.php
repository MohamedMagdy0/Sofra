<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotifiablesTable extends Migration {

	public function up()
	{
		Schema::create('notifiables', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('notification_id')->unsigned();
			$table->integer('notifiable_id')->unsigned();
			$table->string('notifiable_type');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('notifiable');
	}
}
