<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTablePartTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('INV_Movement_Type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->char('operation_type', 1);
            $table->boolean('warehouse_origin_is_requested')->default(false);
            $table->boolean('warehouse_destination_is_requested')->default(false);
            $table->boolean('sales_price_is_requested')->default(false);
            $table->boolean('supplier_is_requested')->default(false);
            $table->boolean('payment_form_is_requested')->default(false);
            $table->boolean('discount_is_requested')->default(false);
            $table->boolean('accounting_movement_is_generated')->default(false);
            $table->boolean('only_show_articles_with_stock')->default(false);
            $table->boolean('calculate_cost')->default(false);
            $table->string('category_debit_account_id', 40)->nullable();
            $table->string('category_credit_account_id', 40)->nullable();
            $table->unsignedInteger('organization_id')->index();

            //foreign Keys
            $table->unsignedInteger('voucher_type_id')->nullable();
            $table->foreign('voucher_type_id')->references('id')->on('ACCT_Voucher_Type');
            $table->unsignedInteger('debit_account_id')->nullable();
            $table->foreign('debit_account_id')->references('id')->on('ACCT_Account');
            $table->unsignedInteger('credit_account_id')->nullable();
            $table->foreign('credit_account_id')->references('id')->on('ACCT_Account');

            //Timestamps
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('INV_Requisition', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('number');
            $table->char('status',1);
            $table->text('remark');
            $table->string('manual_reference', 100)->nullable();
            $table->unsignedInteger('organization_id')->index();


            $table->timestamps();
            $table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('INV_Discount', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->char('type',1);
            $table->float('value');
            $table->unsignedInteger('organization_id')->index();


            $table->timestamps();
            $table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('INV_Movement', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->text('remark');
            $table->integer('number');
            $table->char('status',1);
            $table->string('manual_reference', 100)->nullable();
            $table->unsignedInteger('organization_id')->index();

            //foreign Keys
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('supplier_id')->index()->nullable();
            $table->unsignedInteger('payment_form_id')->index()->nullable();
            $table->unsignedInteger('movement_type_id')->nullable();
            $table->foreign('movement_type_id')->references('id')->on('INV_Movement_Type');

            $table->string('system_reference_type', 40)->index()->nullable();
            $table->string('system_reference_field', 40)->index()->nullable();
            $table->unsignedInteger('system_reference_id')->index()->nullable();

            //Timestamps
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('INV_Movement_Initial_Entry', function (Blueprint $table) {
          $table->increments('id');
          $table->float('quantity');
          $table->double('cost', 13, 2)->default(0);
          $table->double('sales_price', 13, 2)->default(0);
          $table->string('remark')->nullable();
          // $table->double('cost_amount',13,2)->default(0);
          // $table->double('price_amount',13,2)->default(0);

          //foreign Keys
          $table->unsignedInteger('movement_id')->nullable();
          $table->foreign('movement_id')->references('id')->on('INV_Movement');
          $table->unsignedInteger('article_id')->nullable();
          $table->foreign('article_id')->references('id')->on('INV_Article');
          $table->unsignedInteger('warehouse_origin_id')->nullable();
          $table->foreign('warehouse_origin_id')->references('id')->on('INV_Warehouse');
          $table->unsignedInteger('warehouse_destination_id')->nullable();
          $table->foreign('warehouse_destination_id')->references('id')->on('INV_Warehouse');
          $table->unsignedInteger('discount_id')->nullable();
          $table->foreign('discount_id')->references('id')->on('INV_Discount');
          // $table->unsignedInteger('supplier_id')->nullable();
          // $table->foreign('supplier_id')->references('id')->on('PURCH_Supplier');

          $table->string('system_reference_type', 40)->index()->nullable();
          $table->string('system_reference_field', 40)->index()->nullable();
          $table->unsignedInteger('system_reference_id')->index()->nullable();

          $table->unsignedInteger('organization_id')->index();

          //Timestamps
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('INV_Movement_Entry', function (Blueprint $table) {
            $table->increments('id');
            $table->float('quantity');
            $table->double('initial_cost', 13, 2);
            $table->double('cost', 13, 2)->default(0);
            $table->double('sales_price', 13, 2)->default(0);
            $table->string('remark')->nullable();
            // $table->double('cost_amount',13,2)->default(0);
            // $table->double('price_amount',13,2)->default(0);

            $table->float('available_balance')->nullable();
            $table->float('balance')->nullable();

            //foreign Keys
            $table->unsignedInteger('movement_id');
            $table->foreign('movement_id')->references('id')->on('INV_Movement');
            $table->unsignedInteger('movement_initial_entry_id');
            $table->foreign('movement_initial_entry_id')->references('id')->on('INV_Movement_Initial_Entry');
            $table->unsignedInteger('article_id');
            $table->foreign('article_id')->references('id')->on('INV_Article');
            $table->unsignedInteger('warehouse_origin_id')->nullable();
            $table->foreign('warehouse_origin_id')->references('id')->on('INV_Warehouse');
            $table->unsignedInteger('warehouse_destination_id')->nullable();
            $table->foreign('warehouse_destination_id')->references('id')->on('INV_Warehouse');
            $table->unsignedInteger('discount_id')->nullable();
            $table->foreign('discount_id')->references('id')->on('INV_Discount');

            // $table->unsignedInteger('supplier_id')->nullable();
            // $table->foreign('supplier_id')->references('id')->on('PURCH_Supplier');
            // $table->string('system_reference_type', 40)->index()->nullable(); //(nuevo)
      			// $table->string('system_reference_field', 40)->index()->nullable(); //(nuevo)
      			// $table->unsignedInteger('system_reference_id')->index()->nullable(); //(nuevo)

            $table->unsignedInteger('movement_entry_id')->nullable();
            $table->unsignedInteger('organization_id')->index();

            //Timestamps
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('INV_Movement_Entry', function(Blueprint $table)
        {
          //Foreign Key
          $table->foreign('movement_entry_id')->references('id')->on('INV_Movement_Entry');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('INV_Movement_Entry');

        Schema::drop('INV_Movement_Initial_Entry');

        Schema::drop('INV_Movement');

        Schema::drop('INV_Discount');

        Schema::drop('INV_Requisition');

        Schema::drop('INV_Movement_Type');
    }
}
