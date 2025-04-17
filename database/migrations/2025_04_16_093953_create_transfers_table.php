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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_account_id'); // Rekening sumber
            $table->unsignedBigInteger('to_account_id'); // Rekening tujuan
            $table->decimal('amount', 18, 2); // Nominal transfer
            $table->decimal('admin_fee', 18, 2)->default(0); // Biaya admin
            $table->date('date');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('from_account_id')->references('id')->on('accounts');
            $table->foreign('to_account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
