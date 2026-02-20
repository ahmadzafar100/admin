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
        Schema::create('news', function (Blueprint $table) {
            $table->engine('innoDB');
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('summary', 500)->nullable();

            $table->longText('content');

            $table->string('featured_image')->nullable();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('subcategory_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('status', ['draft', 'published', 'archived'])
                ->default('draft');

            $table->date('published_at')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_breaking_news')->default(false);

            $table->integer('views')->default(0);
            $table->bigInteger('likes')->default(0);

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
