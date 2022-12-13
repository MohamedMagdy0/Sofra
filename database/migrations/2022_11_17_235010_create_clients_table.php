<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->string('password');
			$table->string('image')->nullable();
			$table->integer('is_active')->default('1');
			$table->string('api_token')->nullable();
			$table->string('pin_code')->nullable();
			$table->integer('district_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}
