<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->string('commission');
			$table->text('about_app_text');
			$table->string('bank_name');
			$table->string('Bank_account_number');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}