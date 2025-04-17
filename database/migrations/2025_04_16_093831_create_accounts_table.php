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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama rekening
            $table->unsignedBigInteger('currency_id'); // Relasi ke currencies
            $table->decimal('initial_balance', 18, 2)->default(0); // Saldo awal
            $table->decimal('min_balance', 18, 2)->default(0); // Saldo minimum
            $table->enum('type', ['bank', 'ewallet', 'cash', 'other'])->default('bank');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
