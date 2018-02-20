<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTablePartEight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('SYS_Synchronization_File', function (Blueprint $table) {
        $table->increments('id');
        $table->text('json_file');
        $table->text('output_log');
        $table->boolean('syncronized')->default(false);

        //Foreign Keys
        $table->unsignedInteger('organization_id')->index();

        $table->timestamps();
        $table->softDeletes(); //Adds deleted_at column for soft deletes
      });

      Schema::create('SYS_Trash', function (Blueprint $table) {
        $table->increments('id');
        $table->string('table', 20);
        $table->unsignedInteger('cloud_id');
        $table->boolean('syncronized')->default(false);

        //Foreign Keys
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
        Schema::drop('SYS_Trash');
        Schema::drop('SYS_Synchronization_File');
    }
}
