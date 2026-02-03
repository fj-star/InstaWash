<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();

            // siapa yang membuat transaksi (admin / karyawan / pelanggan)
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // pelanggan yang dilayani
            $table->foreignId('pelanggan_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('layanan_id')->constrained('layanans');
            $table->foreignId('treatment_id')->nullable()->constrained('treatments');

            $table->decimal('berat', 8, 2);
            $table->decimal('total_harga', 12, 2);

            // MIDTRANS
            $table->string('order_id')->nullable()->index();
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->enum('payment_status', ['pending','paid','failed','expired'])
                ->default('pending');

                $table->string('snap_token')->nullable();
            $table->enum('metode_pembayaran', ['cash','midtrans'])
                ->default('cash');

            $table->enum('status', ['pending','proses','selesai','batal'])
                ->default('pending');

            $table->enum('created_by', ['admin','karyawan','pelanggan'])
                ->default('pelanggan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
