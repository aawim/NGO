<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
    {
        Schema::create('news_stories', function (Blueprint $table) {
            $table->id();

            // Author
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Content Type
            $table->enum('type', [
                'news',
                'story',
                'press_release',
                'event_update',
                'impact_report'
            ])->default('news');

            // Basic Information
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();

            $table->text('excerpt')->nullable();
            $table->longText('content');

            // Media
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable();

            $table->string('banner_image')->nullable();
            $table->string('video_url')->nullable();

            // Story Information
            $table->string('location')->nullable();

            $table->date('event_date')->nullable();

            // Categories & Tags
            $table->json('categories')->nullable();
            $table->json('tags')->nullable();

            // Publishing
            $table->enum('status', [
                'draft',
                'review',
                'published',
                'archived'
            ])->default('draft');

            $table->boolean('featured')->default(false);

            $table->timestamp('published_at')->nullable();

            // Statistics
            $table->unsignedBigInteger('views')->default(0);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->string('meta_keywords')->nullable();

            // Social Sharing
            $table->string('facebook_title')->nullable();
            $table->string('facebook_image')->nullable();

            $table->string('twitter_title')->nullable();
            $table->string('twitter_image')->nullable();

            // Impact Story Fields
            $table->string('beneficiary_name')->nullable();
            $table->string('beneficiary_photo')->nullable();

            $table->text('impact_summary')->nullable();

            // Sorting
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status']);
            $table->index(['type']);
            $table->index(['featured']);
            $table->index(['published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_stories');
    }
};
