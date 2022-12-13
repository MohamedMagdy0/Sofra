<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->string('title');
			$table->text('content');
			$table->string('image');
			$table->datetime('start_date');
			$table->datetime('end_date');
			$table->integer('restaurant_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}
