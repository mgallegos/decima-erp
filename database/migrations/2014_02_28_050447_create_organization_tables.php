<?php
/**
 * @file
 * Migration script of organization tables.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ORG_Organization', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',60);
			$table->string('street1')->nullable();
			$table->string('street2')->nullable();
      $table->string('city_name')->nullable();
      $table->string('state_name')->nullable();
			$table->string('zip_code', 20)->nullable();
			$table->string('web_site')->nullable();
			$table->string('phone_number',60)->nullable();
			$table->string('fax',60)->nullable();
			$table->string('email')->nullable();
			$table->string('tax_id')->nullable();
			$table->string('company_registration')->nullable();
			$table->string('commercial_trade')->nullable();
			$table->text('logo_url')->nullable();
			$table->tinyInteger('cost_price_precision');
			$table->string('database_connection_name',60);
			$table->string('api_token',60)->nullable();

			//Contact information (clients)

			//Foreign Keys
			$table->unsignedInteger('country_id');
      $table->foreign('country_id')->references('id')->on('SYS_Country');
			$table->unsignedInteger('currency_id')->nullable();
			$table->foreign('currency_id')->references('id')->on('SYS_Currency');
			$table->unsignedInteger('created_by');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
			//defaultLanguage
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ORG_Organization');
	}

}
