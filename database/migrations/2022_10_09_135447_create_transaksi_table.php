<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barang');
            $table->string('qty', 20);
            $table->string('harga', 20);
            $table->string('total_harga', 20);
            $table->string('bulan', 3);
            $table->string('tahun', 5);
            $table->enum('kategori', ['Penjualan', 'Purchase Order', 'Profit', 'Peramalan']);
            $table->timestamps();
            $table->foreign('id_barang')
                ->references('id')->on('barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
