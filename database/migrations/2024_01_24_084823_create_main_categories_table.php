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
        Schema::create('main_categories', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->id();
            $table->string('name',100);
            $table->string('translation_lang',4);
            $table->unsignedInteger('translation_of');
            $table->string('slug',150)->nullable();
            $table->string('photo',150)->nullable();
            $table->tinyInteger('active')->default(1)->comment('0 is inactive || 1 i active');
            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_categories');
    }
};
