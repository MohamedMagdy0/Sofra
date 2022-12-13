<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->string('password');
			$table->decimal('min_charge')->nullable();
			$table->string('image')->nullable();
			$table->string('status')->default('open');
			$table->decimal('delivery_fee');
			$table->string('api_token')->nullable();
			$table->string('pin_code')->nullable();
			$table->integer('district_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}
