<?php

/**
* @file
* Migration script of system tables.
*
* All DecimaAccounting code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
* See COPYRIGHT and LICENSE.
*/

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTablePartOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('INV_Warehouse', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->char('type', 1);
            $table->boolean('is_active');

            //Foreign Keys
            $table->unsignedInteger('cost_center_id')->nullable()->index();
            $table->foreign('cost_center_id')->references('id')->on('ACCT_Cost_Center');
            $table->unsignedInteger('organization_id')->index();

            //Timestamps
            $table->timestamps(); //Adds created_at and updated_at columns
            $table->softDeletes(); //Adds deleted_at column for soft deletes

        });

        Schema::create('INV_Category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->char('class', 1);
            $table->float('profit_margin_percentage')->default(0);

            //Foreign Keys
            $table->unsignedInteger('raw_materials_inventory_account_id')->nullable()->index();
            $table->foreign('raw_materials_inventory_account_id')->references('id')->on('ACCT_Account');
            $table->unsignedInteger('work_in_progress_inventory_account_id')->nullable()->index();
            $table->foreign('work_in_progress_inventory_account_id')->references('id')->on('ACCT_Account');
            $table->unsignedInteger('finished_goods_inventory_account_id')->nullable()->index();
            $table->foreign('finished_goods_inventory_account_id')->references('id')->on('ACCT_Account');
            $table->unsignedInteger('left_over_inventory_account_id')->nullable()->index();
            $table->foreign('left_over_inventory_account_id')->references('id')->on('ACCT_Account');
            $table->unsignedInteger('service_account_id')->nullable()->index();
            $table->foreign('service_account_id')->references('id')->on('ACCT_Account');
            $table->unsignedInteger('cost_expense_account_id')->nullable()->index();
            $table->foreign('cost_expense_account_id')->references('id')->on('ACCT_Account');
            $table->unsignedInteger('consumable_account_id')->nullable()->index();
            $table->foreign('consumable_account_id')->references('id')->on('ACCT_Account');
            $table->unsignedInteger('organization_id')->index();

            //Timestamps
            $table->timestamps(); //Adds created_at and updated_at columns
            $table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('INV_Article_Type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->unsignedInteger('category_id')->nullable()->index();
            $table->unsignedInteger('organization_id')->index();
            $table->foreign('category_id')->references('id')->on('INV_Category');
            //Timestamps
            $table->timestamps(); //Adds created_at and updated_at columns
            $table->softDeletes(); //Adds deleted_at column for soft deletes
        });

        Schema::create('INV_Unit_Measure', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name', 100);
          $table->string('symbol', 5);
          $table->boolean('must_be_whole_number')->default(false);

          //Foreign Keys
          $table->unsignedInteger('organization_id')->index();

          //Timestamps
          $table->timestamps(); //Adds created_at and updated_at columns
          $table->softDeletes(); //Adds deleted_at column for soft deletes
      });

      Schema::create('INV_Unit_Measure_Conversion', function (Blueprint $table) {
          $table->increments('id');
          $table->float('conversion_factor');
          $table->unsignedInteger('organization_id')->index();

          //Foreign Keys
          $table->unsignedInteger('initial_unit_measure_id');
          $table->foreign('initial_unit_measure_id')->references('id')->on('INV_Unit_Measure');
          $table->unsignedInteger('final_unit_measure_id');
          $table->foreign('final_unit_measure_id')->references('id')->on('INV_Unit_Measure');

          //Timestamps
          $table->timestamps(); //Adds created_at and updated_at columns
          $table->softDeletes(); //Adds deleted_at column for soft deletes
      });

      Schema::create('INV_Group', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name', 100);

          //Timestamps
          $table->timestamps(); //Adds created_at and updated_at columns
          $table->softDeletes(); //Adds deleted_at column for soft deletes
      });

      Schema::create('INV_Subgroup', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name', 100);

          //Foreign Keys
          $table->unsignedInteger('group_id')->nullable();
          $table->foreign('group_id')->references('id')->on('INV_Group');

          //Timestamps
          $table->timestamps(); //Adds created_at and updated_at columns
          $table->softDeletes(); //Adds deleted_at column for soft deletes
      });

       Schema::create('INV_Article', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name', 100);
          $table->string('alternative_name', 100)->nullable();
          $table->string('color', 40)->nullable();
          $table->string('size', 20)->nullable();
          $table->string('width', 40)->nullable();
          $table->string('grammage', 40)->nullable();
          $table->string('internal_reference')->nullable();
          $table->string('barcode')->nullable();
          $table->string('hs_code')->nullable();
          $table->boolean('is_third_party_product');
          $table->boolean('is_active');
          $table->text('description')->nullable();

          $table->string('weight', 10)->nullable();
          $table->string('volume', 10)->nullable();
          $table->Integer('minimun_stock')->nullable();
          $table->Integer('maximun_stock')->nullable();

          $table->boolean('is_sales_item');
          $table->double('sales_price', 13,2)->nullable();
          $table->double('list_price', 13,2)->nullable();
          $table->double('offer_price', 13,2)->nullable();
          $table->float('max_discount')->default(0);

          $table->text('image_large_url')->nullable();
          $table->text('image_small_url')->nullable();
          $table->text('image_medium_url')->nullable();
          $table->text('image_url')->nullable();

          $table->string('store_name', 100)->nullable();
          $table->string('tags')->nullable();
          $table->boolean('is_visible_in_store');
          $table->boolean('group_by_name_in_store');

          //Foreign Keys
          $table->unsignedInteger('category_id')->index();
          $table->foreign('category_id')->references('id')->on('INV_Category');
          $table->unsignedInteger('article_type_id')->index();
          $table->foreign('article_type_id')->references('id')->on('INV_Article_Type');
          $table->unsignedInteger('unit_measure_id')->index();
          $table->foreign('unit_measure_id')->references('id')->on('INV_Unit_Measure');
          $table->unsignedInteger('group_id')->nullable();
          $table->foreign('group_id')->references('id')->on('INV_Group');
          $table->unsignedInteger('subgroup_id')->nullable();
          $table->foreign('subgroup_id')->references('id')->on('INV_Subgroup');
          $table->unsignedInteger('organization_id')->index();

          $table->timestamps();
        });

        Schema::create('INV_Setting', function (Blueprint $table) {
          $table->increments('id');
          $table->char('valuation_method', 1)->nullable();
          $table->boolean('is_configure')->nullable();
          $table->unsignedInteger('requisition_user_id')->nullable()->index();
          $table->unsignedInteger('organization_id')->index();
          $table->string('default_so_movement_types', 60)->nullable();

          //Foreign Keys
          $table->unsignedInteger('main_cost_center_id')->nullable()->index();
          $table->foreign('main_cost_center_id')->references('id')->on('ACCT_Cost_Center');

          //Timestamps
          $table->timestamps(); //Adds created_at and updated_at columns
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
      Schema::drop('INV_Setting');

      Schema::drop('INV_Article');

      Schema::drop('INV_Subgroup');

      Schema::drop('INV_Group');

      Schema::drop('INV_Unit_Measure_Conversion');

      Schema::drop('INV_Unit_Measure');

      Schema::drop('INV_Article_Type');

      Schema::drop('INV_Category');

      Schema::drop('INV_Warehouse');
    }
}
