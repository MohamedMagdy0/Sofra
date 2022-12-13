<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->string('address');
			// $table->integer('quantity');
			// $table->decimal('price');
			$table->decimal('total')->default(0);
			$table->decimal('delivery_fee')->default(0);
			$table->decimal('total_price')->default(0);
			$table->decimal('net')->default(0);
			$table->enum('state', array('pending', 'accepted', 'rejected', 'delivered'));
			$table->decimal('app_commission')->default(0);
			$table->integer('client_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
			$table->integer('payment_method_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
