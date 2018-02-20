<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTablePartFour extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PURCH_Payment_Form', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->char('type' , 1)->nullable();
            $table->float('value')->nullable();
            $table->boolean('bank_account_is_requested')->default(false);
            $table->boolean('issue_check')->default(false);
            $table->boolean('petty_cash_is_requested')->default(false);

            //foreign Keys
            $table->unsignedInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('ACCT_Account');
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
        Schema::drop('PURCH_Payment_Form');
    }
}
