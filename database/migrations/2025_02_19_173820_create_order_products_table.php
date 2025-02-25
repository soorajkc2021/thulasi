<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('inventory_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('return_quantity')->nullable();
            $table->decimal('unit_price',10,2)->nullable();
            $table->decimal('unit_cost_price',10,2)->nullable();
            $table->decimal('total_price',10,2)->nullable();
            $table->decimal('total_cost_price',10,2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
