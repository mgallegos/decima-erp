<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcctAccountingTablesPartThree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('ACCT_Apportionment', function (Blueprint $table) {
        $table->increments('id');
        $table->float('percentage');

        //Foreign Keys
        $table->unsignedInteger('cost_center_id')->nullable();
  			$table->foreign('cost_center_id')->references('id')->on('ACCT_Cost_Center');
        $table->unsignedInteger('account_id');
  			$table->foreign('account_id')->references('id')->on('ACCT_Account');
        $table->unsignedInteger('organization_id')->index();

        //Timestamps
  			$table->timestamps(); //Adds created_at and updated_at columns
  			$table->softDeletes(); //Adds deleted_at column for soft deletes
      });

      Schema::create('ACCT_Apportionment_Entry', function (Blueprint $table) {
        $table->increments('id');
        $table->float('percentage');

        //Foreign Keys
        $table->unsignedInteger('apportionment_id');
  			$table->foreign('apportionment_id')->references('id')->on('ACCT_Apportionment');
        $table->unsignedInteger('account_id');
  			$table->foreign('account_id')->references('id')->on('ACCT_Account');
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
      Schema::drop('ACCT_Apportionment_Entry');
      Schema::drop('ACCT_Apportionment');
    }
}
