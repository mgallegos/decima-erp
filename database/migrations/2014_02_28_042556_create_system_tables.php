<?php
/**
 * @file
 * Migration script of system tables.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('SYS_Currency', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('iso_code',3);
			$table->string('symbol',10);
			$table->string('name',60);
			$table->tinyInteger('standard_precision');
			$table->tinyInteger('costing_precision');
			$table->tinyInteger('price_precision');
			$table->boolean('currency_symbol_at_the_right');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SYS_Country', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('iso_code',3);
			$table->string('name',60);
			$table->string('region_name',60);
			$table->string('region_lang_key',100);
			$table->string('tax_id_name')->nullable();
			$table->string('tax_id_abbreviation')->nullable();
			$table->string('registration_number_name')->nullable();
			$table->string('registration_number_abbreviation')->nullable();
			$table->string('single_identity_document_number_name')-nullable();
			$table->string('single_identity_document_number_abbreviation')-nullable();
			$table->string('social_security_number_name')->nullable();
			$table->string('social_security_number_abbreviation')->nullable();
			$table->string('single_previsional_number_name')->nullable();
			$table->string('single_previsional_number_abbreviation')->nullable();

			//Foreign Keys
			$table->unsignedInteger('currency_id')->nullable();
			$table->foreign('currency_id')->references('id')->on('SYS_Currency');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SYS_Region', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',60);
			$table->string('region_code',4)->nullable();
			$table->string('region_lang_key',100)->nullable();

			//Foreign Keys
			$table->unsignedInteger('country_id')->nullable();
			$table->foreign('country_id')->references('id')->on('SYS_Country');

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
		Schema::dropIfExists('SYS_Region');

		Schema::dropIfExists('SYS_Country');

		Schema::dropIfExists('SYS_Currency');
	}

}
