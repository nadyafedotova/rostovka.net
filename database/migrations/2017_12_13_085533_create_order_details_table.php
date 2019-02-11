<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('article', 228);
            $table->string('tovar_name',228);
            $table->integer('rostovka_count');
            $table->integer('box_count');
            $table->integer('prise');
            $table->string('manufacturer_name');
            $table->string('category_name');
            $table->string('currency', 228);
            $table->text('full_description')->nullable();
            $table->string('discount',228);
            $table->boolean('accessibility');
            $table->string('type_name');
            $table->string('season_name');
            $table->string('size_name');
            $table->integer('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('tovar_in_order_count');
            $table->integer('this_tovar_in_order_price');

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
        Schema::dropIfExists('order_details');
    }
}
