<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHumanResourcesTablesPartTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HR_Leave_Type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name' , 100);
            $table->integer('max_days_leave_allowed');
            $table->boolean('is_leave_without_pay');
            $table->boolean('include_holidays_within_leaves_as_leaves');

            //Foreign Keys
            $table->unsignedInteger('organization_id');

            //Timestamps
      			$table->timestamps(); //Adds created_at and updated_at columns
      			$table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('HR_Holiday', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('year');
            $table->date('date');
            $table->text('description');

            //Foreign Keys
            $table->unsignedInteger('organization_id');

            //Timestamps
      			$table->timestamps(); //Adds created_at and updated_at columns
      			$table->softDeletes(); //Adds deleted_at column for soft deletes
        });

         Schema::create('HR_Leave_Application', function (Blueprint $table) {
            $table->increments('id');
            $table->date('from_date');
            $table->date('to_date');
            $table->date('total_leave_days');
            $table->boolean('is_half_day');
            $table->text('reason');
            $table->char('status' , 1);

            //Foreign Keys
            $table->unsignedInteger('organization_id');
            $table->unsignedInteger('applicant_id');
            $table->foreign('applicant_id')->references('id')->on('HR_Employee');
            $table->unsignedInteger('leave_type_id');
            $table->foreign('leave_type_id')->references('id')->on('HR_Leave_Type');
            $table->unsignedInteger('leave_approver_id')->nullable();

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
        Schema::drop('HR_Leave_Application');

        Schema::drop('HR_Holiday');

        Schema::drop('HR_Leave_Type');
    }
}
