<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTablesPartFive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('SALE_Payment', function (Blueprint $table) {
        $table->increments('id');
        $table->date('payment_date')->index()->nullable();
        $table->date('reversal_date')->nullable()->index();
        $table->integer('payment_number')->index()->nullable();
        $table->string('reference_number', 30)->index()->nullable();
        $table->text('payment_remark')->nullable();
        $table->double('payment_tax_amount',13,2)->default(0);
        $table->double('charge_total',13,2)->default(0);
        $table->double('paid_total',13,2)->default(0);
        $table->boolean('is_employee_payment')->default(false);
        $table->char('status', 1)->index();

        //Foreign key
        $table->unsignedInteger('paid_by_id');
        $table->foreign('paid_by_id')->references('id')->on('SALE_Client');
        $table->unsignedInteger('payment_tax_id')->nullable();
        $table->foreign('payment_tax_id')->references('id')->on('PURCH_Tax');
        $table->unsignedInteger('payment_form_id')->nullable();
        $table->foreign('payment_form_id')->references('id')->on('PURCH_Payment_Form');
        $table->unsignedInteger('bank_account_id')->nullable();
        $table->foreign('bank_account_id')->references('id')->on('BANK_Account');
        $table->unsignedInteger('organization_id')->index();

        $table->timestamps();
        $table->softDeletes(); //Adds deleted_at column for soft deletes
      });

      Schema::create('SALE_Order_Payment', function(Blueprint $table)
      {
        $table->increments('id');
        $table->double('payment_amount',13,2)->default(0);

        //Foreign Key
        $table->unsignedInteger('order_id');
        $table->foreign('order_id')->references('id')->on('SALE_Order');
        $table->unsignedInteger('payment_id');
        $table->foreign('payment_id')->references('id')->on('SALE_Payment');
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
      Schema::drop('SALE_Order_Payment');
      Schema::drop('SALE_Payment');
    }
}
