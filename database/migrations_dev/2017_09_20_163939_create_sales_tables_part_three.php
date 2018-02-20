<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTablesPartThree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SALE_Sale_Point', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('government_authorization', 30)->nullable();
            $table->date('authorization_date')->nullable()->index();
            $table->string('finished_goods_warehouse_ids', 30)->nullable();

            //Foreign Key
            // $table->unsignedInteger('finished_goods_warehouse_id')->nullable();//Bodega Productos terminados (nuevo)
            // $table->foreign('finished_goods_warehouse_id')->references('id')->on('INV_Warehouse');
            $table->unsignedInteger('cost_center_id')->nullable();//(nuevo)
            $table->foreign('cost_center_id')->references('id')->on('ACCT_Cost_Center');
            $table->unsignedInteger('account_id')->nullable();
  			    $table->foreign('account_id')->references('id')->on('ACCT_Account');

            $table->unsignedInteger('organization_id')->index();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('SALE_Order', function(Blueprint $table)
    		{
    			//Foreign Key
          $table->foreign('payment_form_id')->references('id')->on('PURCH_Payment_Form');
    			$table->foreign('sale_point_id')->references('id')->on('SALE_Sale_Point');
    			$table->foreign('bank_account_id')->references('id')->on('BANK_Account');
    		});

        Schema::create('SALE_Sale_Point_Document_Type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('initial_number_authorized')->default(0);
            $table->integer('final_number_authorized')->default(0);
            $table->integer('latest_number_issued')->default(0);
            $table->char('print_format_identifier', 6)->nullable(); //nuevo
            $table->string('resolution_number', 100)->nullable(); //nuevo

            $table->unsignedInteger('sale_point_id')->index()->nullable();
            $table->foreign('sale_point_id')->references('id')->on('SALE_Sale_Point');

            $table->unsignedInteger('document_type_id')->index();
            $table->foreign('document_type_id')->references('id')->on('PURCH_Document_Type');

            $table->unsignedInteger('organization_id')->index();

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
        Schema::drop('SALE_Sale_Point_Document_Type');
        Schema::drop('SALE_Sale_Point');
    }
}
