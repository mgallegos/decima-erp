<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FILE_File', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name' , 100);
            $table->char('type' , 1);
            $table->string('system_type', 100)->nullable();
            $table->string('system_route')->nullable();
            $table->text('url')->nullable();
            $table->text('url_html')->nullable();
            $table->boolean('is_public');
            $table->string('key');
            $table->string('icon' , 20);
            $table->string('icon_html');
            $table->unsignedInteger('parent_file_id')->nullable();
            $table->string('system_reference_type' , 40);
            $table->unsignedInteger('system_reference_id');

            //Foreign Keys
            $table->unsignedInteger('organization_id');

            //Timestamps
      			$table->timestamps(); //Adds created_at and updated_at columns
      			$table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::table('FILE_File', function(Blueprint $table)
        {
          //Foreign Key
          $table->foreign('parent_file_id')->references('id')->on('FILE_File');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('FILE_File');
    }
}
