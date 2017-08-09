<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcctAccountingTablesPartTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('ACCT_Journal_Voucher', function(Blueprint $table)
      {
        //Foreign Key
        $table->foreign('document_type_id')->references('id')->on('PURCH_Document_Type');
        $table->foreign('supplier_id')->references('id')->on('PURCH_Supplier');
        $table->foreign('client_id')->references('id')->on('SALE_Client');
        $table->foreign('employee_id')->references('id')->on('HR_Employee');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
