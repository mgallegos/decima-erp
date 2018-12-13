<?php
/**
* @file
* Migration script of security tables.
*
* All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
* See COPYRIGHT and LICENSE.
*/

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecurityTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('SEC_User', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('firstname',60);
			$table->string('lastname',60);
			$table->string('email')->index();
			$table->string('password');
			$table->boolean('is_active')->index();
			$table->boolean('is_admin');
			$table->string('timezone', 60)->nullable();
			$table->string('activation_code')->nullable();
			$table->timestamp('activated_at')->nullable();
			$table->timestamp('last_login')->nullable();
			$table->boolean('popovers_shown')->default(false);
			$table->boolean('multiple_organization_popover_shown')->default(false);
			//$table->string('remember_token',100)->nullable();
			$table->rememberToken();

			//Foreign Keys
			$table->unsignedInteger('created_by')->nullable();
			$table->unsignedInteger('default_organization')->nullable();
			$table->foreign('default_organization')->references('id')->on('ORG_Organization');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});


		Schema::table('SEC_User', function(Blueprint $table)
		{
			//Foreign Key
			$table->foreign('created_by')->references('id')->on('SEC_User');
		});

		Schema::table('ORG_Organization', function(Blueprint $table)
		{
			//Foreign Key
			$table->foreign('created_by')->references('id')->on('SEC_User');
		});


		Schema::create('SEC_Role', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',60);
			$table->string('lang_key',100)->nullable();
			$table->string('description')->nullable();

			//Foreign Keys
			$table->unsignedInteger('organization_id')->index()->nullable();
			$table->foreign('organization_id')->references('id')->on('ORG_Organization');
			$table->unsignedInteger('created_by');
			$table->foreign('created_by')->references('id')->on('SEC_User');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SEC_Module', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',60);
			$table->string('lang_key',100)->nullable();
			$table->string('icon',60)->nullable();

			//Foreign Keys
			$table->unsignedInteger('created_by');
			$table->foreign('created_by')->references('id')->on('SEC_User');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SEC_Menu', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',60);
			$table->string('lang_key',100)->nullable();
			$table->string('url',300)->index()->nullable();
			$table->string('action_button_id',60)->default('');
			$table->string('action_lang_key',100)->nullable();
			$table->string('icon',60)->nullable();

			//Foreign Keys
			$table->unsignedInteger('parent_id')->index()->nullable();
			$table->unsignedInteger('created_by');
			$table->foreign('created_by')->references('id')->on('SEC_User');
			$table->unsignedInteger('module_id')->index();
			$table->foreign('module_id')->references('id')->on('SEC_Module');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::table('SEC_Menu', function(Blueprint $table)
		{
			//Foreign Key
			$table->foreign('parent_id')->references('id')->on('SEC_Menu');
		});

		Schema::create('SEC_Permission', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',60);
			$table->string('key',60);
			$table->string('lang_key',100)->nullable();
			$table->string('url',300)->nullable();
			$table->string('alias_url',300)->nullable();
			$table->string('action_button_id',60)->nullable();
			$table->string('action_lang_key',100)->nullable();
			$table->string('icon',60)->nullable();
			$table->string('shortcut_icon',60)->nullable();
			$table->boolean('is_only_shortcut')->default(false);
			$table->boolean('is_dashboard_shortcut_visible')->default(false);
			$table->boolean('hidden')->default(false);

			//Foreign Keys
			$table->unsignedInteger('menu_id');
			$table->foreign('menu_id')->references('id')->on('SEC_Menu');
			$table->unsignedInteger('created_by');
			$table->foreign('created_by')->references('id')->on('SEC_User');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SEC_User_Role', function(Blueprint $table)
		{
			$table->increments('id');

			//Foreign Keys
			$table->unsignedInteger('user_id')->index();
			$table->foreign('user_id')->references('id')->on('SEC_User');
			$table->unsignedInteger('role_id')->index();
			$table->foreign('role_id')->references('id')->on('SEC_Role');
			$table->unsignedInteger('organization_id')->index();
			$table->foreign('organization_id')->references('id')->on('ORG_Organization');
			$table->unsignedInteger('created_by');
			$table->foreign('created_by')->references('id')->on('SEC_User');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SEC_User_Menu', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('is_assigned')->index();

			//Foreign Keys
			$table->unsignedInteger('user_id')->index();
			$table->foreign('user_id')->references('id')->on('SEC_User');
			$table->unsignedInteger('menu_id')->index();
			$table->foreign('menu_id')->references('id')->on('SEC_Menu');
			$table->unsignedInteger('organization_id')->index();
			$table->foreign('organization_id')->references('id')->on('ORG_Organization');
			$table->unsignedInteger('created_by');
			$table->foreign('created_by')->references('id')->on('SEC_User');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SEC_User_Permission', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('is_assigned')->index();

			//Foreign Keys
			$table->unsignedInteger('user_id')->index();
			$table->foreign('user_id')->references('id')->on('SEC_User');
			$table->unsignedInteger('permission_id')->index();
			$table->foreign('permission_id')->references('id')->on('SEC_Permission');
			$table->unsignedInteger('organization_id')->index();
			$table->foreign('organization_id')->references('id')->on('ORG_Organization');
			$table->unsignedInteger('created_by');
			$table->foreign('created_by')->references('id')->on('SEC_User');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SEC_User_Organization', function(Blueprint $table)
		{
			$table->increments('id');

			//Foreign Keys
			$table->unsignedInteger('user_id')->index();
			$table->foreign('user_id')->references('id')->on('SEC_User');
			$table->unsignedInteger('organization_id')->index();
			$table->foreign('organization_id')->references('id')->on('ORG_Organization');
			$table->unsignedInteger('created_by');
			$table->foreign('created_by')->references('id')->on('SEC_User');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SEC_Role_Menu', function(Blueprint $table)
		{
			$table->increments('id');

			//Foreign Keys
			$table->unsignedInteger('role_id')->index();
			$table->foreign('role_id')->references('id')->on('SEC_Role');
			$table->unsignedInteger('menu_id')->index();
			$table->foreign('menu_id')->references('id')->on('SEC_Menu');
			$table->unsignedInteger('created_by');
			$table->foreign('created_by')->references('id')->on('SEC_User');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SEC_Role_Permission', function(Blueprint $table)
		{
			$table->increments('id');

			//Foreign Keys
			$table->unsignedInteger('role_id')->index();
			$table->foreign('role_id')->references('id')->on('SEC_Role');
			$table->unsignedInteger('permission_id')->index();
			$table->foreign('permission_id')->references('id')->on('SEC_Permission');
			$table->unsignedInteger('created_by');
			$table->foreign('created_by')->references('id')->on('SEC_User');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SEC_Password_Reminders', function(Blueprint $table)
		{
			$table->string('email')->index();
			$table->string('token')->index();
			$table->timestamp('created_at');
		});

		Schema::create('SEC_Journal', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('journalized_id')->index();
			$table->string('journalized_type',30)->index();

			//Foreign Keys
			$table->unsignedInteger('user_id')->index();
			$table->foreign('user_id')->references('id')->on('SEC_User');
			$table->unsignedInteger('organization_id')->nullable();
			$table->foreign('organization_id')->references('id')->on('ORG_Organization');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes

			$table->index('created_at');
		});

		Schema::create('SEC_Journal_Detail', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('field', 60)->nullable();
			$table->string('field_lang_key', 100)->nullable();
			$table->string('note')->nullable();
			$table->text('old_value')->nullable();
			$table->text('new_value')->nullable();

			//Foreign Keys
			$table->unsignedInteger('journal_id')->index();
			$table->foreign('journal_id')->references('id')->on('SEC_Journal');

			//Timestamps
			$table->timestamps(); //Adds created_at and updated_at columns
			$table->softDeletes(); //Adds deleted_at column for soft deletes
		});

		Schema::create('SEC_Failed_Jobs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('connection');
			$table->text('queue');
			$table->text('payload');
			$table->timestamp('failed_at');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::dropIfExists('SEC_Failed_Jobs');

		Schema::dropIfExists('SEC_Journal_Detail');

		Schema::dropIfExists('SEC_Journal');

		Schema::dropIfExists('SEC_Password_Reminders');

		Schema::dropIfExists('SEC_Role_Permission');

		Schema::dropIfExists('SEC_Role_Menu');

		Schema::dropIfExists('SEC_User_Organization');

		Schema::dropIfExists('SEC_User_Permission');

		Schema::dropIfExists('SEC_User_Menu');

		Schema::dropIfExists('SEC_User_Role');

		Schema::dropIfExists('SEC_Permission');

		Schema::dropIfExists('SEC_Menu');

		Schema::dropIfExists('SEC_Module');

		Schema::dropIfExists('SEC_Role');

		Schema::table('ORG_Organization', function(Blueprint $table)
		{
			$table->dropForeign('org_organization_created_by_foreign');
		});

		Schema::dropIfExists('SEC_User');

	}

}
