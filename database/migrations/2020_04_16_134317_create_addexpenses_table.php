<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddexpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_expenses', function (Blueprint $table) {
            $table->Integer('expense_id')->primary();
            $table->string('type');
            $table->string('category');
            $table->string('ename');
            $table->string('amount');
            $table->bigInteger('added_by');
            $table->dateTime('date');
            $table->foreign('added_by')->references('id')->on('users');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_expenses');
    }
}
