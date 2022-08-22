<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('nota', 255);
            $table->enum('status', ['y', 'n'])->default('y');
            $table->date('tanggal');
            $table->integer('qty');
            $table->integer('pajak')->default(0);
            $table->integer('diskon')->default(0);
            $table->double('subTotal', 9,2);
            $table->foreign('item')->references('id')->on('obats')->onDelete('cascade');
            $table->unsignedBigInteger('item');
            $table->foreign('consumer')->references('id')->on('pasiens')->onDelete('cascade');
            $table->unsignedBigInteger('consumer');
            $table->foreign('kasir')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('kasir');
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
        Schema::dropIfExists('penjualans');
    }
}
