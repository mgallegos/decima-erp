<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHumanResourcesTablesPartThree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HR_Phase', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->tinyInteger('position');
            $table->unsignedInteger('organization_id')->index();

            //Timestamps
            $table->timestamps();  //Adds created_at and updated_at columns
            $table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('HR_Task', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->float('planned_initial_hour');
            $table->date('limit_date');
            $table->char('priority', 1);
            $table->tinyInteger('position');
            $table->text('manual_reference')->nullable();
            $table->tinyInteger('completion_percentage');

            //Foreign Keys
            $table->unsignedInteger('organization_id')->index();
      			$table->unsignedInteger('responsible_employee_id')->nullable();
      			$table->foreign('responsible_employee_id')->references('id')->on('HR_Employee');
            $table->unsignedInteger('phase_id')->nullable();
      			$table->foreign('phase_id')->references('id')->on('HR_Phase');

            //Timestamps
            $table->timestamps();  //Adds created_at and updated_at columns
            $table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('HR_Worked_Hour', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->text('description')->nullable();
            $table->text('url')->nullable();
            $table->float('worked_hours')->default(0);
            $table->unsignedInteger('organization_id')->index();

            //Foreign Keys
      			$table->unsignedInteger('responsible_employee_id')->nullable();
      			$table->foreign('responsible_employee_id')->references('id')->on('HR_Employee');
            $table->unsignedInteger('task_id')->nullable();
            $table->foreign('task_id')->references('id')->on('HR_Task');

            //Timestamps
            $table->timestamps();  //Adds created_at and updated_at columns
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
        Schema::drop('HR_Worked_Hour');

        Schema::drop('HR_Task');

        Schema::drop('HR_Phase');
    }
}
