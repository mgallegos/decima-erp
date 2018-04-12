<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTablePartSix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('PURCH_Order', function(Blueprint $table)
      {
        //Foreign Key
        $table->foreign('bank_account_id')->references('id')->on('BANK_Account');
        $table->foreign('petty_cash_id')->references('id')->on('BANK_Petty_Cash');
      });

      Schema::create('PURCH_Payment', function (Blueprint $table) {
          $table->increments('id');
          $table->date('payment_date')->index()->nullable();
          $table->date('reversal_date')->nullable()->index();
          $table->integer('check_number')->index()->nullable();
          $table->integer('payment_number')->index()->nullable();
          $table->string('reference_number', 30)->index()->nullable();
          $table->string('check_name')->nullable();
          $table->text('payment_remark')->nullable();
          $table->double('payment_tax_amount',13,2)->default(0);
          $table->double('charge_total',13,2)->default(0);
          $table->double('paid_total',13,2)->default(0);
          $table->char('status', 1)->index();

          //Foreign key
          $table->unsignedInteger('paid_to_id');
          $table->foreign('paid_to_id')->references('id')->on('PURCH_Supplier');
          $table->unsignedInteger('payment_tax_id')->nullable();
          $table->foreign('payment_tax_id')->references('id')->on('PURCH_Tax');
          $table->unsignedInteger('payment_form_id')->nullable();
          $table->foreign('payment_form_id')->references('id')->on('PURCH_Payment_Form');
          $table->unsignedInteger('bank_account_id')->nullable();
    			$table->foreign('bank_account_id')->references('id')->on('BANK_Account');
          $table->unsignedInteger('petty_cash_id')->nullable();
          $table->foreign('petty_cash_id')->references('id')->on('BANK_Petty_Cash');
          $table->unsignedInteger('organization_id')->index();

          $table->timestamps();
          $table->softDeletes(); //Adds deleted_at column for soft deletes
      });

      Schema::create('PURCH_Order_Payment', function(Blueprint $table)
      {
        $table->increments('id');
        $table->double('payment_amount',13,2)->default(0);

        //Foreign Key
        $table->unsignedInteger('order_id');
        $table->foreign('order_id')->references('id')->on('PURCH_Order');
        $table->unsignedInteger('payment_id');
        $table->foreign('payment_id')->references('id')->on('PURCH_Payment');
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
      Schema::drop('PURCH_Order_Payment');
      Schema::drop('PURCH_Payment');
    }
}
