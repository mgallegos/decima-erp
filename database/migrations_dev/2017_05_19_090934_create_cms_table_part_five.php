<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTablePartFive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CMS_Setting_Purchase_Method', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->text('instructions');

            //Foreign Keys
            $table->unsignedInteger('setting_id')->index();
      			$table->foreign('setting_id')->references('id')->on('CMS_Setting');

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
        Schema::drop('CMS_Setting_Purchase_Method');
    }
}
