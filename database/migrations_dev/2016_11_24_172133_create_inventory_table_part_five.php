<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTablePartFive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('INV_Daily_Movement', function (Blueprint $table) {
        $table->increments('id');
        $table->date('date');
        $table->double('cost', 13, 2);
        $table->float('balance');
        $table->float('accumulated_balance');

        //foreign Keys
        $table->unsignedInteger('organization_id')->index();
        $table->unsignedInteger('article_id')->index();
        $table->foreign('article_id')->references('id')->on('INV_Article');
        $table->unsignedInteger('warehouse_id')->nullable();
        $table->foreign('warehouse_id')->references('id')->on('INV_Warehouse');

        //Timestamps
        $table->timestamps();
        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('INV_Daily_Movement');
    }
}
