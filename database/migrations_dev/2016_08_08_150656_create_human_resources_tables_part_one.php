<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHumanResourcesTablesPartOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HR_Department', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name' , 100);
            $table->unsignedInteger('cost_center_id')->nullable();
            $table->unsignedInteger('organization_id');
            $table->foreign('cost_center_id')->references('id')->on('ACCT_Cost_Center');

            //Timestamps
      			$table->timestamps(); //Adds created_at and updated_at columns
      			$table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('HR_Position', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name' , 100);
            $table->double('salary' , 13,2);
            $table->unsignedInteger('organization_id');

            //Timestamps
      			$table->timestamps(); //Adds created_at and updated_at columns
      			$table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('HR_AFP', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name' , 100);
            $table->float('commission');
            $table->float('employer_contribution');
            $table->float('employee_contribution') ;
            $table->unsignedInteger('organization_id');
            //Timestamps
      			$table->timestamps(); //Adds created_at and updated_at columns
      			$table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('HR_Employee', function (Blueprint $table) {
            $table->increments('id');
            $table->string('names');
            $table->string('surnames');
            $table->char('gender' , 1);
            $table->char('marital_status' , 1);
            $table->tinyInteger('children_number')->nullable();
            $table->string('place_birth' , 100);
            $table->date('date_birth');
            $table->unsignedInteger('country_id');
            $table->char('status' , 1);
            $table->string('tax_id')->nullable();
            $table->string('tax_id_name')->nullable();
            $table->string('single_identity_document_number', 60)->nullable();
            $table->string('single_identity_document_number_name')->nullable();
            $table->string('social_security_number', 60)->nullable();
            $table->string('social_security_number_name')->nullable();
            $table->unsignedInteger('afp_id')->nullable();
            $table->string('single_previsional_number', 60)->nullable();
            $table->string('single_previsional_number_name')->nullable();
            $table->string('passport_number' , 60)->nullable();
            $table->string('street1')->nullable();
            $table->string('street2')->nullable();
            $table->string('city_name')->nullable();
            $table->string('state_name')->nullable();
            $table->string('zip_code', 20)->nullable();
            $table->string('personal_email')->nullable();
            $table->string('residence_phone' , 20)->nullable();
            $table->string('mobile_phone' , 20)->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_phone' , 20)->nullable();
            $table->char('blood_type' , 1)->nullable();
            $table->unsignedInteger('departament_id')->nullable();
            $table->unsignedInteger('position_id')->nullable();
            $table->double('salary' , 13,2)->nullable();
            $table->date('start_date')->nullable();
            $table->string('bank_account_number' , 60)->nullable();
            $table->string('work_email')->nullable();
            $table->string('work_phone' , 20)->nullable();
            $table->string('work_phone_extension' , 20)->nullable();
            $table->text('profile_image_url')->nullable();
            $table->text('profile_image_medium_url')->nullable();
            $table->text('profile_image_small_url')->nullable();
            $table->string('work_mobile' , 20)->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('leave_approver_id')->nullable();
            $table->unsignedInteger('organization_id');
            $table->foreign('departament_id')->references('id')->on('HR_Department');
            $table->foreign('position_id')->references('id')->on('HR_Position');

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
        Schema::drop('HR_Employee');

        Schema::drop('HR_AFP');

        Schema::drop('HR_Position');

        Schema::drop('HR_Department');
    }
}
