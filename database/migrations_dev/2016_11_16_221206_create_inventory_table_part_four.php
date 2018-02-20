<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTablePartFour extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('INV_Requisition_Entry', function (Blueprint $table) {
            $table->increments('id');
            $table->float('quantity');
            $table->unsignedInteger('organization_id')->index();
            $table->unsignedInteger('requisition_id');
            $table->foreign('requisition_id')->references('id')->on('INV_Requisition');
            $table->unsignedInteger('article_id');
            $table->foreign('article_id')->references('id')->on('INV_Article');
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
        Schema::drop('INV_Requisition_Entry');
    }
}
