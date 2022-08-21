<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('faktur');
            $table->string('item');
            $table->double('harga', 9,2);
            $table->integer('qty');
            $table->date('tanggal');
            $table->double('totalKotor', 9,2);
            $table->integer('pajak');
            $table->integer('diskon');
            $table->double('totalBersih', 9,2);
            $table->text('keterangan');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('admin')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('admin');
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
        Schema::dropIfExists('pembelians');
    }
}
