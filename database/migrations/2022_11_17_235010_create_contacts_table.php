<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {

            $table->softDeletes();
			$table->increments('id');
			$table->string('full_name');
			$table->string('email');
			$table->string('phone');
			$table->enum('type', array('complain', 'suggestion', 'query'));
			$table->string('message');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('contacts');
	}
}
