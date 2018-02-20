<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTablePartSeven extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('INV_Brand', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);

            //Timestamps
            $table->timestamps(); //Adds created_at and updated_at columns
            $table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('INV_Model', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);

            //Foreign Keys
            $table->unsignedInteger('brand_id')->index()->nullable();
            $table->foreign('brand_id')->references('id')->on('INV_Brand');

            //Timestamps
            $table->timestamps(); //Adds created_at and updated_at columns
            $table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('INV_Article_Brand_Model', function (Blueprint $table) {
          $table->increments('id');

          //Foreign Keys
          $table->unsignedInteger('article_id');
          $table->foreign('article_id')->references('id')->on('INV_Article');
          $table->unsignedInteger('brand_id');
          $table->foreign('brand_id')->references('id')->on('INV_Brand');
          $table->unsignedInteger('model_id')->nullable();
          $table->foreign('model_id')->references('id')->on('INV_Model');
          $table->unsignedInteger('organization_id')->index();

          //Timestamps
          $table->timestamps(); //Adds created_at and updated_at columns
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
        Schema::drop('INV_Article_Group_Subgroup');
        Schema::drop('INV_Subgroup');
        Schema::drop('INV_Group');
        Schema::drop('INV_Article_Brand_Model');
        Schema::drop('INV_Model');
        Schema::drop('INV_Brand');
    }
}
