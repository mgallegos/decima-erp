<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTablePartTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PURCH_Document_Type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            // $table->tinyInteger('latest_number_issued')->default(0);
            $table->string('price_tax_ids', 30)->nullable();
            $table->char('print_format_identifier', 6)->nullable();
            $table->boolean('has_decrease_effect')->default(false);
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
        Schema::drop('PURCH_Document_Type');
    }
}
