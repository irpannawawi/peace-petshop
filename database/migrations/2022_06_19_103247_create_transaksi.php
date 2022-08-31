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
            $table->increments('kd_transaksi')->primary;
            $table->string('invoice');
            $table->integer('kd_cust');
            $table->integer('kd_produk');
            $table->integer('harga_satuan');
            $table->integer('qty');
            $table->string('tanggal', 50);
            $table->enum('pembayaran',['Bank BCA', 'Bank Mandiri']);
            $table->string('bukti_pembayaran', 100);
            $table->enum('status', ['menunggu pembayaran', 'pesanan terkirim', 'pesanan diterima', 'pesanan dibatalkan', 'selesai']);
            $table->integer('diskon')->default(0)->nullable();
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
