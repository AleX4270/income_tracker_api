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
        Schema::create('income', function(Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'income_user_id'
            );
            $table->foreignId('income_category_id')->constrained(
                table: 'income_category', indexName: 'income_income_category_id'
            );
            $table->foreignId('currency_id')->constrained(
                table: 'currency', indexName: 'income_currency_id'
            );
            $table->decimal('amount');
            $table->date('date_received');
            $table->string('description', 512)->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('income');
    }
};
