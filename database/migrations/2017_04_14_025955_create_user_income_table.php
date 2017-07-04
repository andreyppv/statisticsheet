<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserIncomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('year');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->decimal('jan', 10, 2)->default(0)->unsigned();
            $table->decimal('feb', 10, 2)->default(0)->unsigned();
            $table->decimal('mar', 10, 2)->default(0)->unsigned();
            $table->decimal('apr', 10, 2)->default(0)->unsigned();
            $table->decimal('may', 10, 2)->default(0)->unsigned();
            $table->decimal('jun', 10, 2)->default(0)->unsigned();
            $table->decimal('jul', 10, 2)->default(0)->unsigned();
            $table->decimal('aug', 10, 2)->default(0)->unsigned();
            $table->decimal('sep', 10, 2)->default(0)->unsigned();
            $table->decimal('oct', 10, 2)->default(0)->unsigned();
            $table->decimal('nov', 10, 2)->default(0)->unsigned();
            $table->decimal('dec', 10, 2)->default(0)->unsigned();
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
        Schema::dropIfExists('user_incomes');
    }
}
