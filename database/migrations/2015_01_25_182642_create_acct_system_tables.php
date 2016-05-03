<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcctSystemTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('SYS_Account_Type', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',60);
			$table->string('lang_key',100)->nullable();
			$table->char('key', 1);
			$table->char('pl_bs_category', 1);
			$table->char('deferral_method', 1);

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SYS_Account_Chart_Type', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',60);
			$table->string('url');
			$table->string('lang_key',100)->nullable();

			//Foreign Keys
			$table->unsignedInteger('country_id')->nullable();
			$table->foreign('country_id')->references('id')->on('SYS_Country');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SYS_Voucher_Type', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('lang_key',100)->nullable();
			$table->char('key', 1)->nullable();

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SYS_Account', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('key');
			$table->string('parent_key')->nullable();
			$table->string('name');
			$table->char('balance_type', 1);
			$table->char('account_type_key', 1);
			$table->boolean('is_group')->default(false);

			//Foreign Keys
			$table->unsignedInteger('account_chart_type_id')->nullable();
			$table->foreign('account_chart_type_id')->references('id')->on('SYS_Account_Chart_Type');

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
		Schema::dropIfExists('SYS_Account');

		Schema::dropIfExists('SYS_Account_Chart_Type');

		Schema::dropIfExists('SYS_Voucher_Type');

		Schema::dropIfExists('SYS_Account_Type');
	}

}
