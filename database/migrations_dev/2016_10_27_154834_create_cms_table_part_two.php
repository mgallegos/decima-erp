<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTablePartTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CMS_Gallery', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('website_section_id');
            $table->unsignedInteger('organization_id')->index();

            //Timestamps
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('CMS_Gallery_Detail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->text('image_url');
            $table->text('destination_url')->nullable();
            $table->unsignedInteger('gallery_id');
            $table->unsignedInteger('organization_id');

            //Timestamps
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('CMS_Website_Section', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->char('internal_reference',2);
            $table->unsignedInteger('organization_id')->index();

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
        Schema::drop('CMS_Website_Section');

        Schema::drop('CMS_Gallery_Detail');

        Schema::drop('CMS_Gallery');
    }
}
