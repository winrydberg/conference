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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('house')->nullable();
            $table->string('yeargroup')->nullable();
            $table->string('occupation')->nullable();
            $table->longText('extras')->nullable();
            $table->longText('otherdata')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('paid')->nullable();
            $table->bigInteger('conference_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
