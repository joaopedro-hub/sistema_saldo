<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('type',['I','O','T']);//tipo da movimentação I(recarga),O(saida),T(transferencia)
            $table->double('amount',10,2);//total movimentado
            $table->double('total_before',10,2);//total que tinha antes
            $table->double('total_after', 10, 2);//total que ficou depois
            $table->integer('user_id_transaction')->nullable();//armazena o id do usuario que fez a transação
            $table->date('date');//data que fez a transação
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historics');
    }
}
