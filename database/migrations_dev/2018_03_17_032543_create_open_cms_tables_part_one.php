<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpenCmsTablesPartOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('OCMS_Setting', function (Blueprint $table) {
          $table->increments('id');

          $table->text('transport_type_values')->nullable();
          $table->text('presentation_type_values')->nullable();
          $table->text('assigned_transport_values')->nullable();

          $table->boolean('is_configured')->default(false)->index();
          $table->unsignedInteger('organization_id')->index();
          $table->timestamps();
      });

        Schema::create('OCMS_User', function (Blueprint $table) {
          $table->increments('id');
          $table->string('firstname',60);
    			$table->string('lastname',60);
    			$table->string('email')->index();
    			$table->string('password');
    			$table->boolean('is_active')->default(false)->index();
    			$table->string('activation_code')->nullable();
    			$table->timestamp('activated_at')->nullable();
    			$table->timestamp('last_login')->nullable();
    			$table->rememberToken();

    			//Timestamps
    			$table->timestamps(); //Adds created_at and updated_at columns
    			$table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('OCMS_Event', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name', 100);
          $table->string('short_name', 20)->nullable();
          $table->string('path', 20)->nullable();
          $table->text('logo_url')->nullable();
          $table->text('place_url')->nullable();

          $table->boolean('speakers_section_is_enabled')->default(false);
          $table->boolean('agenda_section_is_enabled')->default(false);
          $table->boolean('place_section_is_enabled')->default(false);
          $table->boolean('participants_section_is_enabled')->default(false);
          $table->boolean('sponsors_section_is_enabled')->default(false);
          $table->boolean('registration_section_is_enabled')->default(false);
          $table->boolean('is_active')->default(false);

          //foreign Keys
          $table->unsignedInteger('organization_id')->index();

          //Timestamps
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('OCMS_User_Event', function (Blueprint $table) {
          $table->increments('id');

          //foreign Keys
          $table->unsignedInteger('user_id')->index();
          $table->foreign('user_id')->references('id')->on('OCMS_User');
          $table->unsignedInteger('event_id')->index();
          $table->foreign('event_id')->references('id')->on('OCMS_Event');
          $table->unsignedInteger('organization_id')->index();

          //Timestamps
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('OCMS_Transportation_Request', function (Blueprint $table) {
          $table->increments('id');
          $table->char('type', 1);
          $table->dateTime('pickup_datetime');
          $table->string('pickup_place', 100);
          $table->string('transport_number', 60)->nullable();
          $table->string('assigned_transport')->nullable();
          $table->text('remark')->nullable();
          $table->boolean('is_approved')->default(false);

          //foreign Keys
          $table->unsignedInteger('event_id')->index();
          $table->foreign('event_id')->references('id')->on('OCMS_Event');
          $table->unsignedInteger('request_user_id')->index();
          $table->foreign('request_user_id')->references('id')->on('OCMS_User');
          $table->unsignedInteger('responsable_user_id')->index();
          $table->foreign('responsable_user_id')->references('id')->on('OCMS_User');
          $table->unsignedInteger('organization_id')->index();

          //Timestamps
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('OCMS_Space', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name', 100);
          $table->integer('capacity')->default(0);
          $table->integer('duration_interval')->default(0);
          $table->string('location')->nullable();
          $table->boolean('is_active')->default(false);

          //foreign Keys
          $table->unsignedInteger('event_id')->index();
          $table->foreign('event_id')->references('id')->on('OCMS_Event');
          $table->unsignedInteger('responsable_user_id')->index();
          $table->foreign('responsable_user_id')->references('id')->on('OCMS_User');
          $table->unsignedInteger('organization_id')->index();

          //Timestamps
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('OCMS_Schedule', function (Blueprint $table) {
          $table->increments('id');
          $table->dateTime('date_time');
          $table->boolean('is_available')->default(true);

          //foreign Keys
          $table->unsignedInteger('space_id')->index();
          $table->foreign('space_id')->references('id')->on('OCMS_Space');

          $table->unsignedInteger('organization_id')->index();

          //Timestamps
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('OCMS_Presentation', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name', 100);
          $table->text('description')->nullable();
          $table->string('type', 60);
          $table->float('duration')->default(0);

          $table->boolean('is_approved')->default(false);

          //foreign Keys
          $table->unsignedInteger('event_id')->index();
          $table->foreign('event_id')->references('id')->on('OCMS_Event');
          $table->unsignedInteger('space_id')->index();
          $table->foreign('space_id')->references('id')->on('OCMS_Space');
          $table->unsignedInteger('user_id')->index();
          $table->foreign('user_id')->references('id')->on('OCMS_User');
          $table->unsignedInteger('organization_id')->index();

          //Timestamps
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('OCMS_Presentation_Schedule', function (Blueprint $table) {
          $table->increments('id');

          //foreign Keys
          $table->unsignedInteger('presentation_id')->index();
          $table->foreign('presentation_id')->references('id')->on('OCMS_Presentation');
          $table->unsignedInteger('schedule_id')->index();
          $table->foreign('schedule_id')->references('id')->on('OCMS_Schedule');

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
        Schema::drop('OCMS_Presentation_Schedule');
        Schema::drop('OCMS_Presentation');
        Schema::drop('OCMS_Schedule');
        Schema::drop('OCMS_Space');
        Schema::drop('OCMS_Transportation_Request');
        Schema::drop('OCMS_User_Event');
        Schema::drop('OCMS_Event');
        Schema::drop('OCMS_User');
    }
}
