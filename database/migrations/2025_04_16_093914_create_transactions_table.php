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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id'); // Rekening terkait
            $table->enum('type', ['income', 'expense', 'admin_fee'])->default('expense');
            $table->decimal('amount', 18, 2);
            $table->string('category')->nullable();
            $table->string('description')->nullable();
            $table->date('date');
            $table->string('attachment')->nullable();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
