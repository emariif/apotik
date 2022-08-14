<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockObatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_obats', function (Blueprint $table) {
            $table->id();
            $table->foreign('obat_id')->references('id')->on('obats')->onDelete('cascade');
            $table->unsignedBigInteger('obat_id');
            $table->integer('masuk');
            $table->integer('keluar');
            $table->decimal('jual',9,2);
            $table->decimal('beli',9,2);
            $table->date('expired');
            $table->integer('stock');
            $table->text('keterangan');
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
        Schema::dropIfExists('stock_obats');
    }
}
