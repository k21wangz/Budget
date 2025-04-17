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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // Contoh: IDR, USD
            $table->string('name', 50); // Contoh: Rupiah, Dollar
            $table->string('symbol', 5); // Contoh: Rp, $
            $table->decimal('rate_to_idr', 18, 4)->default(1); // Kurs ke IDR
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
