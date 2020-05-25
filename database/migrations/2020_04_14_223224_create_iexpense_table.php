<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIexpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iexpense', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->Integer('expense_id');
            $table->bigInteger('user_id');
            $table->string('iamount');
            $table->tinyInteger('paid_by');
            $table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('expense_id')->references('expense_id')->on('add_expenses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iexpense');
    }
}
