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
        Schema::table('conference_abstracts', function (Blueprint $table) {
            $table->longText('comments')->nullable();
            $table->string('journal_publication')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conference_abstracts', function (Blueprint $table) {
            $table->dropColumn('journal_publication');
            $table->dropColumn('comments');
        });
    }
};
