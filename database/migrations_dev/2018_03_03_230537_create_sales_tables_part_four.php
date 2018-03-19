<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTablesPartFour extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('SALE_Order_Synchronized', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('quote_number')->nullable();
          $table->integer('sale_order_number')->nullable();
          $table->integer('document_number')->nullable();
          $table->integer('payment_number')->index()->nullable();//new
          $table->string('modify_document_number')->index()->nullable();
          $table->string('reference_number', 30)->index()->nullable();//new
          $table->date('quote_date')->nullable()->index();
          $table->date('emission_date')->nullable()->index();
          $table->date('expiration_date')->nullable()->index();
          $table->date('registration_date')->nullable()->index();
          $table->date('payment_date')->nullable()->index();
          $table->date('collection_date')->nullable()->index();
          $table->date('reversal_date')->nullable()->index();
          $table->char('status', 1)->index();
          $table->char('type', 1);
          $table->text('remark');
          $table->text('payment_remark')->nullable();//new
          $table->double('not_subject_amount_sum',13,2)->default(0);
          $table->double('exempt_amount_sum',13,2)->default(0);
          $table->double('subject_amount_sum',13,2)->default(0);
          $table->double('collected_tax_amount_sum',13,2)->default(0);
          $table->double('withheld_tax_amount_sum',13,2)->default(0);
          $table->double('sales_total',13,2)->default(0);
          $table->double('advanced_paid_total',13,2)->default(0);
          $table->double('payment_tax_amount',13,2)->default(0);
          $table->double('charge_total',13,2)->default(0);
          $table->double('paid_total',13,2)->default(0);
          $table->boolean('syncronized')->default(false);

          //Foreign key
          $table->unsignedInteger('client_id')->index();
          // $table->foreign('client_id')->references('id')->on('SALE_Client');
          $table->unsignedInteger('payment_term_id')->index();
          // $table->foreign('payment_term_id')->references('id')->on('PURCH_Payment_Term');
          $table->unsignedInteger('payment_form_id')->index()->nullable();//null
          // $table->foreign('payment_form_id')->references('id')->on('PURCH_Payment_Form');
          $table->unsignedInteger('payment_tax_id')->index();
          // $table->foreign('payment_tax_id')->references('id')->on('PURCH_Tax');
          $table->unsignedInteger('document_type_id')->index()->nullable();
          // $table->foreign('document_type_id')->references('id')->on('PURCH_Document_Type');
          $table->unsignedInteger('sale_point_id')->index()->nullable();//null
          $table->unsignedInteger('bank_account_id')->index()->nullable();
          $table->unsignedInteger('sale_order_id')->nullable();
          $table->unsignedInteger('created_by')->index();//nuevo
          $table->unsignedInteger('organization_id')->index();

          $table->timestamps();
          $table->softDeletes(); //Adds deleted_at column for soft deletes
      });

      Schema::create('SALE_Order_Synchronized_Detail', function (Blueprint $table) {
          $table->increments('id');
          $table->float('quantity');
          $table->double('price_without_discount', 13, 6);
          $table->double('price', 13, 6);
          $table->double('not_subject_amount',13,2)->default(0);
          $table->double('exempt_amount',13,2)->default(0);
          $table->double('subject_amount',13,2)->default(0);
          $table->string('alternative_name')->nullable();
          $table->string('remark')->nullable();
          $table->double('cost', 13, 6)->nullable();
          //Foreign key
          $table->unsignedInteger('order_id')->index();
          // $table->foreign('order_id')->references('id')->on('SALE_Order_Synchronized');
          $table->unsignedInteger('article_id')->index();
          // $table->foreign('article_id')->references('id')->on('INV_Article');
          $table->unsignedInteger('discount_id')->nullable()->index();
          // $table->foreign('discount_id')->references('id')->on('INV_Discount');
          $table->unsignedInteger('movement_entry_id')->nullable();// (nuevo)
          // $table->foreign('movement_entry_id')->references('id')->on('INV_Movement_Entry');
          $table->unsignedInteger('warehouse_origin_id')->nullable()->index();
          // $table->foreign('warehouse_origin_id')->references('id')->on('INV_Warehouse');
          $table->unsignedInteger('organization_id')->index();

          $table->timestamps();
          $table->softDeletes(); //Adds deleted_at column for soft deletes
      });

      Schema::create('SALE_Order_Synchronized_Tax', function (Blueprint $table) {
          $table->increments('id');
          $table->double('own_not_subject_amount_total',13,2)->default(0);
          $table->double('own_exempt_amount_total',13,2)->default(0);
          $table->double('own_subject_amount_total',13,2)->default(0);
          $table->double('own_subject_amount_tax_total',13,2);
          $table->double('third_party_not_subject_amount_total',13,2)->default(0);
          $table->double('third_party_exempt_amount_total',13,2)->default(0);
          $table->double('third_party_subject_amount_total',13,2)->default(0);
          $table->double('third_party_subject_amount_tax_total',13,2);

          //Foreign key
          $table->unsignedInteger('order_id')->index();
          // $table->foreign('order_id')->references('id')->on('SALE_Order_Synchronized');
          $table->unsignedInteger('tax_id')->index();
          // $table->foreign('tax_id')->references('id')->on('PURCH_Tax');
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
        Schema::drop('SALE_Order_Synchronized_Tax');
        Schema::drop('SALE_Order_Synchronized_Detail');
        Schema::drop('SALE_Order_Synchronized');
    }
}
