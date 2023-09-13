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
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->string('venue')->nullable();
            $table->time('starttime')->nullable();
            $table->time('endtime')->nullable();
            $table->text('description')->nullable();
            $table->string('regtable')->nullable();
            $table->longText('extras')->nullable();
            $table->boolean('isopen')->nullable()->default(false);
            $table->string('url')->nullable();
            $table->string('token')->nullable();
            $table->string('departmentlogo')->nullable();
            $table->string('event_flyer')->nullable();
            $table->longText('attachments')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conferences');
    }
};
