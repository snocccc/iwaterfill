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
        Schema::table('historicals', function (Blueprint $table) {
            $table->boolean('is_processed')->default(false); // default value is false

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historical', function (Blueprint $table) {
            $table->dropColumn('is_processed');
        });
    }
};
