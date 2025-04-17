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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('expense'); // Jenis budget: income/expense
            $table->string('budget_name'); // Nama budget
            $table->string('category'); // Kategori budget
            $table->unsignedBigInteger('account_id')->nullable(); // Rekening terkait (opsional)
            $table->unsignedBigInteger('currency_id'); // Mata uang
            $table->decimal('amount', 18, 2); // Nominal budget
            $table->enum('period', ['monthly', 'yearly'])->default('monthly'); // Periode
            $table->integer('year');
            $table->integer('month')->nullable(); // Jika monthly
            $table->decimal('carry_over', 18, 2)->default(0); // Sisa bulan lalu
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
        Schema::dropIfExists('budgets');
    }
};
