<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankTablesPartOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('BANK_Bank', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name', 100);
          $table->string('street1')->nullable();
          $table->string('street2')->nullable();
          $table->string('city_name')->nullable();
          $table->string('state_name')->nullable();
          $table->string('zip_code', 20)->nullable();
          $table->string('web_site')->nullable();
          $table->string('contact_name')->nullable();
          $table->string('phone_number', 60)->nullable();
          $table->string('fax', 60)->nullable();
          $table->string('email')->nullable();
          $table->unsignedInteger('country_id')->nullable();

          $table->unsignedInteger('organization_id');

          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('BANK_Account', function (Blueprint $table){
          $table->increments('id');
          $table->string('name', 100);
          $table->string('number', 100);
          $table->char('type' , 1);
          $table->integer('latest_number_issued')->default(0);
          $table->char('print_format_identifier', 6)->nullable();
          $table->float('balance', 13,2)->default(0);
          $table->boolean('is_active')->default(1);

          $table->unsignedInteger('account_id')->nullable();
          $table->foreign('account_id')->references('id')->on('ACCT_Account');

          $table->unsignedInteger('bank_id')->nullable();
          $table->foreign('bank_id')->references('id')->on('BANK_Bank');

          $table->unsignedInteger('organization_id');

          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('BANK_Petty_Cash', function(Blueprint $table){
          $table->increments('id');
          $table->string('name', 100);
          $table->float('allocated_amount', 13,2);
          $table->float('balance', 13,2);
          $table->boolean('is_active')->default(1);

          $table->unsignedInteger('responsible_employee_id')->nullable();
          $table->foreign('responsible_employee_id')->references('id')->on('HR_Employee');

          $table->unsignedInteger('voucher_type_id')->nullable();
          $table->foreign('voucher_type_id')->references('id')->on('ACCT_Voucher_Type');

          $table->unsignedInteger('account_id')->nullable();
          $table->foreign('account_id')->references('id')->on('ACCT_Account');

          $table->unsignedInteger('organization_id');

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
        Schema::drop('BANK_Petty_Cash');
        Schema::drop('BANK_Account');
        Schema::drop('BANK_Bank');
    }
}
