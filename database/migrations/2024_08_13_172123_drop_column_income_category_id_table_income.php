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
        Schema::table('income', function (Blueprint $table) {
            $table->dropForeign('income_income_category_id');
            $table->dropColumn('income_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('income', function(Blueprint $table) {
           $table->foreignId('income_category_id')->after('user_id')->constrained(
               table: 'income_category', indexName: 'income_income_category_id'
           );
        });
    }
};
