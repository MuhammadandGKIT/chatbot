<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id(); // ID unik
            $table->string('no_invoice')->unique(); // Nomor invoice / pesanan
            $table->string('status')->default('Pesanan Diterima'); // Status pengiriman
            $table->dateTime('order_date')->nullable(); // Tanggal pesanan dibuat
            $table->dateTime('shipped_date')->nullable(); // Tanggal dikirim
            $table->dateTime('delivered_date')->nullable(); // Tanggal diterima
            $table->string('recipient_name')->nullable(); // Nama penerima
            $table->string('shipping_address')->nullable(); // Alamat tujuan
            $table->string('tracking_number')->nullable(); // Nomor resi
            $table->string('courier')->nullable(); // Nama kurir
            $table->text('note')->nullable(); // Catatan tambahan
            $table->decimal('total_payment', 15, 2)->nullable(); // Total harga
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
