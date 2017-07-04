<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->boolean('expand')->default(1);
            $table->smallInteger('priority')->default(1);
            $table->string('hash', 32);
            $table->timestamps();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_categories');
    }
}
