<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('home_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('h1')->nullable();
            $table->string('h2')->nullable();
            $table->text('body')->nullable();
            $table->string('btn_text')->nullable()->default('Get in touch');
            $table->string('btn_link')->nullable()->default('/contact');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('home_sliders');
    }
};
