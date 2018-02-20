<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTablePartFive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('PURCH_Setting', function (Blueprint $table) {
          $table->increments('id');

          //Quotes and purchases
          $table->string('taxes', 100)->nullable();
          $table->string('quote_user_ids', 30)->nullable();
          $table->string('sale_order_user_ids', 30)->nullable();
          $table->string('account_receivable_user_ids', 30)->nullable();
          $table->boolean('only_show_discount_articles')->default(false);
          //Purchases book
          $table->unsignedInteger('sales_tax_id')->nullable();
          $table->foreign('sales_tax_id')->references('id')->on('PURCH_Tax');
          $table->unsignedInteger('collected_tax_id')->nullable();
          $table->foreign('collected_tax_id')->references('id')->on('PURCH_Tax');
          $table->unsignedInteger('withheled_tax_id')->nullable();
          $table->foreign('withheled_tax_id')->references('id')->on('PURCH_Tax');
          $table->string('other_tax_ids', 30)->nullable();
          $table->string('domestic_purchases_document_type_ids', 30)->nullable();
          $table->string('international_purchases_document_type_ids', 30)->nullable();
          $table->string('excluded_document_type_ids', 30)->nullable();
          $table->string('decrease_document_type_ids', 30)->nullable();
          $table->string('signer_title', 60)->nullable();
          $table->string('signer_name', 60)->nullable();

          //Recibo Sujeto Excluído
          $table->string('receipt_header')->nullable();
          $table->text('receipt_body')->nullable();//textarea
          $table->string('receipt_footer')->nullable();

          //Accounting
          $table->unsignedInteger('voucher_type_id')->nullable();
          $table->foreign('voucher_type_id')->references('id')->on('ACCT_Voucher_Type');
          $table->unsignedInteger('main_cost_center_id')->nullable();
          $table->foreign('main_cost_center_id')->references('id')->on('ACCT_Cost_Center');
          $table->unsignedInteger('advanced_paid_account_id')->nullable();
          $table->foreign('advanced_paid_account_id')->references('id')->on('ACCT_Account');
          $table->unsignedInteger('payable_account_id')->nullable();
          $table->foreign('payable_account_id')->references('id')->on('ACCT_Account');
          $table->boolean('accounting_movement_is_generated')->default(false);

          //Inventory
          $table->unsignedInteger('movement_type_id')->nullable();
          $table->foreign('movement_type_id')->references('id')->on('INV_Movement_Type');
          $table->unsignedInteger('movement_type_decrease_id')->nullable();
          $table->foreign('movement_type_decrease_id')->references('id')->on('INV_Movement_Type');
          // $table->unsignedInteger('warehouse_destination_id')->nullable();
          // $table->foreign('warehouse_destination_id')->references('id')->on('INV_Warehouse');
          $table->boolean('raw_materials_inventory_movement_is_generated')->default(false);

          $table->unsignedInteger('raw_materials_warehouse_id')->nullable();//Bodega Materia prima
          $table->foreign('raw_materials_warehouse_id')->references('id')->on('INV_Warehouse');

          $table->boolean('finished_goods_inventory_movement_is_generated')->default(false);

          $table->unsignedInteger('finished_goods_warehouse_id')->nullable();//Bodega Productos terminados
          $table->foreign('finished_goods_warehouse_id')->references('id')->on('INV_Warehouse');

          $table->boolean('consumable_inventory_movement_is_generated')->default(false);

          $table->unsignedInteger('consumable_warehouse_id')->nullable();//Consumibles
          $table->foreign('consumable_warehouse_id')->references('id')->on('INV_Warehouse');

          $table->boolean('only_show_articles_with_stock')->default(false);

          $table->boolean('is_configured')->default(false);
          $table->unsignedInteger('organization_id')->index();

          $table->timestamps();
          $table->softDeletes(); //Adds deleted_at column for soft deletes
      });

        Schema::create('PURCH_Order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_number')->index()->nullable();
            $table->integer('purchase_order_number')->index()->nullable();
            $table->integer('requisition_number')->index()->nullable();
            $table->integer('check_number')->index()->nullable();
            $table->integer('payment_number')->index()->nullable();//new
            $table->date('purchase_order_date')->index()->nullable();
            $table->date('requisition_date')->index()->nullable();
            $table->date('emission_date')->index()->nullable();
            $table->date('registration_date')->index()->nullable();
            $table->date('payment_date')->index()->nullable();
            $table->date('due_date')->index()->nullable();
            $table->date('reversal_date')->nullable()->index();
            $table->string('document_number', 30)->index()->nullable();
            $table->string('modify_document_number', 30)->index()->nullable();
            $table->string('reference_number', 30)->index()->nullable();//new
            $table->string('check_name')->nullable();
            $table->char('status', 1)->index();
            $table->char('type', 1)->index();
            $table->text('remark')->nullable();
            $table->text('payment_remark')->nullable();//new
            $table->double('not_subject_amount_sum',13,2)->default(0);
            $table->double('exempt_amount_sum',13,2)->default(0);
            $table->double('subject_amount_sum',13,2)->default(0);
            $table->double('collected_tax_amount_sum',13,2)->default(0);
            $table->double('withheld_tax_amount_sum',13,2)->default(0);
            $table->double('purchase_total',13,2)->default(0);
            $table->double('advanced_paid_total',13,2)->default(0);

            //Foreign key
            $table->unsignedInteger('supplier_id')->index()->nullable();
            $table->foreign('supplier_id')->references('id')->on('PURCH_Supplier');
            $table->unsignedInteger('paid_to_id')->index()->nullable();//new
            $table->foreign('paid_to_id')->references('id')->on('PURCH_Supplier');
            $table->unsignedInteger('document_type_id')->index()->nullable();
            $table->foreign('document_type_id')->references('id')->on('PURCH_Document_Type');
            $table->unsignedInteger('payment_term_id')->index()->nullable();
            $table->foreign('payment_term_id')->references('id')->on('PURCH_Payment_Term');
            $table->unsignedInteger('payment_form_id')->index()->nullable();
            $table->foreign('payment_form_id')->references('id')->on('PURCH_Payment_Form');
            $table->unsignedInteger('warehouse_destination_id')->nullable();
            $table->foreign('warehouse_destination_id')->references('id')->on('INV_Warehouse');
            $table->unsignedInteger('department_destination_id')->nullable();
            $table->foreign('department_destination_id')->references('id')->on('HR_Department');
            $table->unsignedInteger('bank_account_id')->index()->nullable();
            $table->unsignedInteger('petty_cash_id')->index()->nullable();
            $table->unsignedInteger('created_by')->index();//nuevo
            $table->unsignedInteger('organization_id')->index();

            $table->timestamps();
            $table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('PURCH_Order_Detail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alternative_name')->nullable();
            $table->float('quantity');
            $table->double('price', 13, 2);
            $table->double('not_subject_amount',13,2)->default(0);
            $table->double('exempt_amount',13,2)->default(0);
            $table->double('subject_amount',13,2)->default(0);
            $table->string('remark')->nullable();
            // $table->double('not_subject_amount_total',13,2)->default(0);
            // $table->double('exempt_amount_total',13,2)->default(0);
            // $table->double('subject_amount_total',13,2)->default(0);

            //Foreign key
            $table->unsignedInteger('order_id')->index();
            $table->foreign('order_id')->references('id')->on('PURCH_Order');
            $table->unsignedInteger('article_id')->index();
            $table->foreign('article_id')->references('id')->on('INV_Article');
            $table->unsignedInteger('discount_id')->nullable()->index();
            $table->foreign('discount_id')->references('id')->on('INV_Discount');
            $table->unsignedInteger('organization_id')->index();

            $table->timestamps();
            $table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('PURCH_Order_Tax', function (Blueprint $table) {
            $table->increments('id');
            $table->double('not_subject_amount_total',13,2)->default(0);
            $table->double('exempt_amount_total',13,2)->default(0);
            $table->double('subject_amount_total',13,2)->default(0);
            $table->double('subject_amount_tax_total',13,2);

            //Foreign key
            $table->unsignedInteger('order_id')->index();
            $table->foreign('order_id')->references('id')->on('PURCH_Order');
            $table->unsignedInteger('tax_id')->index();
            $table->foreign('tax_id')->references('id')->on('PURCH_Tax');
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
      Schema::drop('PURCH_Order_Tax');
      Schema::drop('PURCH_Order_Detail');
      Schema::drop('PURCH_Order');
      Schema::drop('PURCH_Setting');
    }
}
