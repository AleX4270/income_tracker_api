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
        Schema::create('income_category_translation', function(Blueprint $table) {
            $table->id();
            $table->foreignId('income_category_id')->constrained(
                table: 'income_category', indexName: 'income_category_translation_income_category_id'
            );
            $table->foreignId('language_id')->constrained(
                table: 'language', indexName: 'income_category_translation_language_id'
            );
            $table->string('name', 255);
            $table->string('description', 512);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('income_category_translation');
    }
};
