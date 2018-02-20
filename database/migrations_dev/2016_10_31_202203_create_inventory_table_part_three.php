<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTablePartThree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('INV_Article_Discount', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_id');
            $table->foreign('article_id')->references('id')->on('INV_Article');
            $table->unsignedInteger('discount_id');
            $table->foreign('discount_id')->references('id')->on('INV_Discount');
            $table->unsignedInteger('organization_id')->index();

            $table->timestamps();
            $table->softDeletes(); //Adds deleted_at column for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('INV_Article_Discount');
    }
}
