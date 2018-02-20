<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTablePartSix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('INV_Article_Gallery', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->text('image_url');
            $table->unsignedInteger('article_id')->index();
            $table->unsignedInteger('organization_id')->index();
            // Foreign key
            $table->foreign('article_id')->references('id')->on('INV_Article');
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
        Schema::drop('INV_Article_Gallery');
    }
}
