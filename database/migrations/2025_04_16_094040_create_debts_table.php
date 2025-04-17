<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['receivable', 'payable']); // Piutang/Utang
            $table->string('contact_name'); // Nama pihak terkait
            $table->unsignedBigInteger('account_id'); // Rekening terkait
            $table->unsignedBigInteger('currency_id'); // Mata uang
            $table->decimal('amount', 18, 2); // Nominal
            $table->decimal('paid', 18, 2)->default(0); // Sudah dibayar
            $table->date('date'); // Tanggal transaksi
            $table->date('due_date')->nullable(); // Jatuh tempo
            $table->string('description')->nullable();
            $table->boolean('is_settled')->default(false); // Status lunas
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
