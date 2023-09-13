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
        Schema::create('conference_abstracts', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('institution')->nullable();
            $table->longText('title')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->longText('coauthors')->nullable();
            $table->string('corresponding_authorname')->nullable();
            $table->string('corresponding_authoremail')->nullable();
            $table->string('thematic')->nullable();
            $table->string('presentationtype')->nullable();
            $table->string('document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_abstracts');
    }
};
