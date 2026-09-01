<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_type_id')->constrained()->restrictOnDelete();
            $table->foreignId('city_id')->constrained()->restrictOnDelete();
            $table->foreignId('area_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('compound_id')->nullable()->constrained()->nullOnDelete();
            $table->json('title');
            $table->json('slug');
            $table->json('description')->nullable();
            $table->json('features')->nullable();
            $table->string('listing_type');
            $table->decimal('price', 15, 2);
            $table->string('currency', 3)->default('EGP');
            $table->decimal('property_area_sqm', 10, 2)->nullable();
            $table->unsignedTinyInteger('bedrooms')->nullable();
            $table->unsignedTinyInteger('bathrooms')->nullable();
            $table->string('floor')->nullable();
            $table->string('furnished')->nullable();
            $table->string('status')->default('available');
            $table->string('google_maps_url')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('featured_image')->nullable();
            $table->json('seo_title')->nullable();
            $table->json('seo_description')->nullable();
            $table->string('og_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_published', 'status', 'listing_type']);
            $table->index(['city_id', 'area_id', 'compound_id']);
            $table->index(['price', 'property_area_sqm']);
            $table->index(['bedrooms', 'bathrooms']);
            $table->index('is_featured');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
