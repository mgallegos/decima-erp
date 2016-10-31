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

class CreateAcctAccountingTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*Schema::create('ACCT_User', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('firstname',60);
			$table->string('lastname',60);
			$table->string('email');
			//$table->boolean('is_active');
			//$table->boolean('is_admin');
			//$table->string('timezone', 60)->nullable();
			//$table->unsignedInteger('main_db_id')->nullable();

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});*/


		Schema::create('ACCT_Setting', function(Blueprint $table)
		{
			$table->increments('id');
			$table->smallInteger('initial_year')->nullable();;
			$table->char('voucher_numeration_type', 1)->nullable();//Periodo,Period:P and Periodo y tipo de partida, Period and Voucher Type: A
			$table->boolean('create_opening_period')->default(false);
			$table->boolean('create_closing_period')->default(false);
			$table->boolean('is_configured')->default(false);

			//Foreign Keys
			$table->unsignedInteger('account_chart_type_id')->index()->nullable();
			$table->unsignedInteger('organization_id')->index();

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('ACCT_Fiscal_Year', function(Blueprint $table)
		{
			$table->increments('id');
			$table->smallInteger('year')->index();
			$table->date('start_date');
			$table->date('end_date');
			$table->boolean('is_closed')->default(false);

			//Foreign Keys
			$table->unsignedInteger('organization_id')->index();

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('ACCT_Period', function(Blueprint $table)
		{
			$table->increments('id');
			$table->smallInteger('month');
			$table->date('start_date');
			$table->date('end_date');
			$table->boolean('is_closed')->default(false);

			//Foreign Keys
			$table->unsignedInteger('fiscal_year_id')->index();
			$table->foreign('fiscal_year_id')->references('id')->on('ACCT_Fiscal_Year');

			$table->unsignedInteger('organization_id')->index();

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});


		Schema::create('ACCT_Account_Type', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('lang_key',100)->nullable();
			$table->char('key', 1)->nullable();
			$table->char('pl_bs_category', 1)->index();//Pérdidas y Ganancias (Cuenta de ingresos) -- B, Pérdidas y Ganancias (Cuenta de gastos) -- C, Balance (Cuenta de activo)  -- D, Balance (Cuenta de pasivo) -- E

			$table->char('deferral_method', 1)->nullable();

			//Foreign Keys
			$table->unsignedInteger('organization_id')->index();

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('ACCT_Account', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('key');
			$table->string('name');
			$table->char('balance_type', 1);//Deudor,Receivable:D and Acreedor,Payable: A
			$table->boolean('is_group')->index()->default(false);

			//Foreign Keys
			$table->unsignedInteger('account_type_id')->index();
			$table->foreign('account_type_id')->references('id')->on('ACCT_Account_Type');
			$table->unsignedInteger('parent_account_id')->index()->nullable();
			$table->unsignedInteger('organization_id')->index();

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::table('ACCT_Account', function(Blueprint $table)
		{
			//Foreign Key
			$table->foreign('parent_account_id')->references('id')->on('ACCT_Account');
		});

		Schema::create('ACCT_Cost_Center', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('key');
			$table->string('name');
			//$table->char('type', 1);//Group (G) or Ledger (L)
			$table->boolean('is_group')->index()->default(false);

			//Foreign Keys
			$table->unsignedInteger('parent_cc_id')->index()->nullable();
			$table->unsignedInteger('organization_id')->index();

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::table('ACCT_Cost_Center', function(Blueprint $table)
		{
			//Foreign Key
			$table->foreign('parent_cc_id')->references('id')->on('ACCT_Cost_Center');
		});

		Schema::create('ACCT_Voucher_Type', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('lang_key',100)->nullable();
			$table->char('key', 1)->nullable();//Opening Entry: O, Closing Entry: C

			//Foreign Keys
			$table->unsignedInteger('organization_id')->index();

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('ACCT_Journal_Voucher', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('number')->index();
			$table->dateTime('date');
			$table->string('manual_reference')->nullable();
			$table->text('remark');
			$table->string('system_reference_type', 40)->index()->nullable();
			$table->string('system_reference_field', 40)->index()->nullable();
			$table->unsignedInteger('system_reference_id')->index()->nullable();
			$table->boolean('is_editable')->default(false);
			$table->char('status', 1)->index();//A = No Cuadrada, B = Cuadrada

			//document
			$table->date('document_date')->nullable();
			$table->unsignedInteger('document_type_id')->index()->nullable();
			$table->string('document_number', 20)->index()->nullable();
			$table->unsignedInteger('supplier_id')->index()->nullable();
			$table->unsignedInteger('client_id')->index()->nullable();

			//Foreign Keys
			$table->unsignedInteger('voucher_type_id')->index();
			$table->foreign('voucher_type_id')->references('id')->on('ACCT_Voucher_Type');
			$table->unsignedInteger('period_id')->index();
			$table->foreign('period_id')->references('id')->on('ACCT_Period');
			$table->unsignedInteger('created_by');
			//$table->foreign('created_by')->references('id')->on('ACCT_User');
			$table->unsignedInteger('organization_id')->index();

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes

			$table->index('deleted_at');
		});

		Schema::create('ACCT_Journal_Entry', function(Blueprint $table)
		{
			$table->increments('id');
			//$table->float('number');
			$table->double('debit', 13, 2);
			$table->double('credit', 13, 2);
			$table->string('system_reference_type', 40)->index()->nullable();
			$table->string('system_reference_field', 40)->index()->nullable();
			$table->unsignedInteger('system_reference_id')->index()->nullable();

			//Foreign Keys
			$table->unsignedInteger('journal_voucher_id')->index()->nullable();
			$table->foreign('journal_voucher_id')->references('id')->on('ACCT_Journal_Voucher');
			$table->unsignedInteger('cost_center_id');
			$table->foreign('cost_center_id')->references('id')->on('ACCT_Cost_Center');
			$table->unsignedInteger('account_id');
			$table->foreign('account_id')->references('id')->on('ACCT_Account');
			//$table->unsignedInteger('organization_id');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes

			$table->index('deleted_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ACCT_Journal_Entry');

		Schema::dropIfExists('ACCT_Journal_Voucher');

		Schema::dropIfExists('ACCT_Voucher_Type');

		Schema::dropIfExists('ACCT_Cost_Center');

		Schema::dropIfExists('ACCT_Account');

		Schema::dropIfExists('ACCT_Account_Type');

		Schema::dropIfExists('ACCT_Period');

		Schema::dropIfExists('ACCT_Fiscal_Year');

		Schema::dropIfExists('ACCT_Setting');

		Schema::dropIfExists('ACCT_User');
	}
}
