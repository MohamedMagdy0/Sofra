<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration {

	public function up()
	{
		Schema::create('items', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->string('name');
			$table->string('description');
			$table->decimal('price');
			$table->decimal('sale_price');
			$table->text('notes');
			$table->string('service_time');
			$table->string('image');
			$table->integer('category_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('items');
	}
}
