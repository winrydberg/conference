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
            $table->longText('bankinfo')->nullable();
            $table->string('payment_modes')->nullable();
            $table->string('reg_startdate')->nullable();
            $table->string('reg_enddate')->nullable();
            $table->longText('organizers')->nullable();
            $table->longText('benefits')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropColumn('bankinfo');
            $table->dropColumn('payment_modes');
            $table->dropColumn('reg_startdate');
            $table->dropColumn('reg_enddate');
            $table->dropColumn('organizers');
            $table->dropColumn('benefits');
        });
    }
};
