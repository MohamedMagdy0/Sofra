<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {

	public function up()
	{
		Schema::create('payments', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->datetime('date_of_paid');
			$table->decimal('paid')->default(0);
			$table->text('notes');
			$table->integer('restaurant_id')->unsigned();
			$table->integer('order_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('payments');
	}
}
