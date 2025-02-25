<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
           
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('cascade');
           
            $table->string('unit_quantity',100)->nullable();
            $table->decimal('cost_price',10,2)->nullable();
            $table->decimal('sell_price',10,2)->nullable();
            $table->integer('stock')->nullable();
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
        Schema::dropIfExists('inventories');
    }
}
