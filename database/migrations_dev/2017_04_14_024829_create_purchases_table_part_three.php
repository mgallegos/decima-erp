<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTablePartThree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PURCH_Tax', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->char('type' , 1);
            $table->char('purchase_tax_effect' , 1);
            $table->char('sale_tax_effect' , 1);
            $table->float('value');
            // $table->string('formula');
            $table->string('proof_concept')->nullable();

            //foreign Keys
            $table->unsignedInteger('purchase_account_id')->nullable();
            $table->foreign('purchase_account_id')->references('id')->on('ACCT_Account');
            // $table->unsignedInteger('sale_account_id')->nullable();
            // $table->foreign('sale_account_id')->references('id')->on('ACCT_Account');
            $table->unsignedInteger('own_sale_account_id')->nullable(); // nuevo
            $table->foreign('own_sale_account_id')->references('id')->on('ACCT_Account');
            $table->unsignedInteger('third_sale_account_id')->nullable(); // nuevo
            $table->foreign('third_sale_account_id')->references('id')->on('ACCT_Account');
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
        Schema::drop('PURCH_Tax');
    }
}
