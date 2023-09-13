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
        Schema::table('conferences', function (Blueprint $table) {
            $table->string('googlemaps')->nullable();
            $table->string('brochure')->nullable();
            $table->boolean('require_payment')->nullable();
            $table->bigInteger('payment_mode_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropColumn('googlemaps');
            $table->dropColumn('brochure');
            $table->dropColumn('require_payment');
            $table->dropColumn('payment_mode_id');
        });
    }
};
