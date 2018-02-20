<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTablesPartOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SALE_Client', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
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
            $table->string('tax_id')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('single_identity_document_number')->nullable();
            $table->string('commercial_trade')->nullable();
            $table->date('date_birth')->nullable();

            //foreign key
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('taxpayer_classification_id')->nullable();
            $table->foreign('taxpayer_classification_id')->references('id')->on('PURCH_Taxpayer_Classification');
            $table->unsignedInteger('payment_term_id')->nullable();
            $table->foreign('payment_term_id')->references('id')->on('PURCH_Payment_Term');
            $table->unsignedInteger('receivable_account_id')->nullable();// (nuevo) Cuenta por cobrar
            $table->foreign('receivable_account_id')->references('id')->on('ACCT_Account');
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
        Schema::drop('SALE_Client');
    }
}
