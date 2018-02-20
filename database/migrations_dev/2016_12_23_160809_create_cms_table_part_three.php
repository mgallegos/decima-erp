<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTablePartThree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CMS_Setting', function (Blueprint $table) {
            $table->increments('id');

            //Virtual Store fields
            $table->string('buy_message')->nullable();
            $table->string('buy_button_text')->nullable();
            $table->string('user_for_notification')->nullable();
            //$table->string('articles_columns_to_be_shown')->nullable();
            $table->string('timezone', 60)->nullable();
            $table->text('store_logo_url')->nullable();
            $table->integer('articles_per_page')->nullable();
            $table->double('shipping_cost', 13, 2)->nullable();
            $table->boolean('only_show_articles_with_stock')->nullable();
            $table->boolean('cash_payment_is_enabled')->nullable();
            $table->boolean('credit_debit_payment_is_enabled')->nullable();
            $table->boolean('pick_up_in_store_is_enabled')->nullable();
            $table->boolean('delivery_is_enabled')->nullable();
            $table->unsignedInteger('default_purchase_order_user')->nullable()->index();
            $table->unsignedInteger('movement_type_id')->nullable()->index();
            //Adress
            $table->string('street1')->nullable();
            $table->string('city_name')->nullable();
            $table->string('state_name')->nullable();
            $table->string('zip_code', 20)->nullable();
            $table->string('store_phone_number', 20)->nullable();
            $table->string('warehouses_id', 20)->nullable();
            //Cotizaciones
            $table->boolean('quote_is_enabled')->nullable();
            $table->string('quote_button_text')->nullable();

            $table->boolean('is_configured')->nullable();
            $table->unsignedInteger('organization_id')->index();
            $table->timestamps();
        });

        Schema::create('CMS_Purchase_Order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number');
            $table->char('delivery_method', 1);
            // $table->char('payment_method');
            $table->double('amount', 13, 2);
            $table->double('shipping_cost', 13, 2);
            $table->char('status', 1);
            $table->char('type', 1);//P => Pedido, C => Cotización
            $table->text('remark')->nullable();
            $table->string('manual_reference')->nullable();
            $table->dateTime('date');
            $table->date('pick_up_date')->nullable();

            //foreign Keys
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('purchase_method_id')->index();
            $table->unsignedInteger('client_id')->index();
            $table->foreign('client_id')->references('id')->on('SALE_Client');
            $table->unsignedInteger('organization_id')->index();
            $table->timestamps();
        });

        Schema::create('CMS_Purchase_Order_Detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity');
            $table->double('sub_total', 13,2);

            $table->unsignedInteger('order_id');
            $table->foreign('order_id')->references('id')->on('CMS_Purchase_Order');
            // $table->unsignedInteger('movement_entry_id');
            // $table->foreign('movement_entry_id')->references('id')->on('INV_Movement_Entry');
            $table->unsignedInteger('article_id');
            $table->foreign('article_id')->references('id')->on('INV_Article');
            $table->unsignedInteger('discount_id')->nullable();
            $table->foreign('discount_id')->references('id')->on('INV_Discount');

            $table->unsignedInteger('organization_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('CMS_Purchase_Order');

      Schema::drop('CMS_Purchase_Order_Detail');

      Schema::drop('CMS_Setting');
    }
}
