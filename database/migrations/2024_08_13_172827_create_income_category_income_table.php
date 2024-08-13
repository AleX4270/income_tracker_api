<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('income_category_income', function (Blueprint $table) {
            $table->id();
            $table->foreignId('income_id')->constrained(
                table: 'income', indexName: 'income_category_income_income_id'
            );
            $table->foreignId('income_category_id')->constrained(
                table: 'income_category', indexName: 'income_category_income_income_category_id'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('income_category_income');
    }
};
