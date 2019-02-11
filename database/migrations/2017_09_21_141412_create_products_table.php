<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('article', 228);
            $table->string('name',228);
            $table->string('sex',228)->nullable();
            $table->string('material',228)->nullable();
            $table->string('tip_vyazki',228)->nullable();
            $table->integer('rostovka_count');
            $table->integer('box_count');
            $table->float('prise');
            $table->integer('manufacturer_id');
            $table->foreign('manufacturer_id')
                ->references('id')
                ->on('manufacturers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->boolean('show_product');
            $table->string('currency', 228);
            $table->text('full_description')->nullable();
            $table->string('discount',228);
            $table->boolean('accessibility');
            $table->integer('type_id');
            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('season_id');
            $table->foreign('season_id')
                ->references('id')
                ->on('seasons')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('size_id');
            $table->foreign('size_id')
                ->references('id')
                ->on('sizes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
        Schema::dropIfExists('products');
    }
}
