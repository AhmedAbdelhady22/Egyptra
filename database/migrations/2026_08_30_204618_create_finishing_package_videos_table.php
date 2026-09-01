<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finishing_package_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finishing_package_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('url');
            $table->string('url')->nullable();
            $table->string('path')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finishing_package_videos');
    }
};
