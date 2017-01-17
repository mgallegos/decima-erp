<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecurityFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SEC_File', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('file_id')->index();
            $table->string('key');
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
        Schema::drop('ORG_Organization_File');
    }
}
