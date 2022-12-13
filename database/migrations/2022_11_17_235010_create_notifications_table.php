<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->string('title');
			$table->text('content');
			// $table->integer('model_id')->unsigned();
			// $table->string('model_type');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}
