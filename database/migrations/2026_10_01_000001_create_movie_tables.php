<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Mở rộng bảng users (NguoiDung)
        Schema::table('users', function (Blueprint $t) {
            $t->string('role', 20)->default('member');
            $t->string('avatar')->nullable();
            $t->boolean('is_active')->default(true);
        });

        Schema::create('categories', function (Blueprint $t) {
            $t->id();
            $t->string('name', 50)->unique();
            $t->timestamps();
        });

        Schema::create('movies', function (Blueprint $t) {
            $t->id();
            $t->string('title', 200);
            $t->string('original_title', 200)->nullable();
            $t->text('description')->nullable();
            $t->unsignedSmallInteger('year')->nullable();
            $t->unsignedInteger('duration')->nullable();
            $t->string('poster')->nullable();
            $t->string('trailer')->nullable();
            $t->string('country', 50)->nullable();
            $t->string('type', 10)->default('le'); // le | bo
            $t->boolean('is_vip')->default(false);
            $t->unsignedInteger('views')->default(0);
            $t->timestamps();
        });

        Schema::create('category_movie', function (Blueprint $t) {
            $t->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $t->foreignId('category_id')->constrained()->cascadeOnDelete();
            $t->primary(['movie_id', 'category_id']);
        });

        Schema::create('episodes', function (Blueprint $t) {
            $t->id();
            $t->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $t->unsignedInteger('number');
            $t->string('title', 100)->nullable();
            $t->string('video_url');
            $t->unsignedInteger('duration')->nullable();
            $t->timestamps();
        });

        Schema::create('actors', function (Blueprint $t) {
            $t->id();
            $t->string('name', 100);
            $t->date('birthday')->nullable();
            $t->string('nationality', 50)->nullable();
            $t->string('photo')->nullable();
            $t->timestamps();
        });

        Schema::create('actor_movie', function (Blueprint $t) {
            $t->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $t->foreignId('actor_id')->constrained()->cascadeOnDelete();
            $t->string('role_name', 100)->nullable();
            $t->primary(['movie_id', 'actor_id']);
        });

        Schema::create('comments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $t->string('content', 1000);
            $t->timestamps();
        });

        Schema::create('ratings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $t->unsignedTinyInteger('stars');
            $t->timestamps();
            $t->unique(['user_id', 'movie_id']);
        });

        Schema::create('watch_histories', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('episode_id')->constrained()->cascadeOnDelete();
            $t->unsignedInteger('progress')->default(0);
            $t->timestamps();
            $t->unique(['user_id', 'episode_id']);
        });

        Schema::create('favorites', function (Blueprint $t) {
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $t->timestamps();
            $t->primary(['user_id', 'movie_id']);
        });

        Schema::create('vip_plans', function (Blueprint $t) {
            $t->id();
            $t->string('name', 50);
            $t->unsignedInteger('price');
            $t->unsignedInteger('days');
            $t->timestamps();
        });

        Schema::create('vip_subscriptions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('vip_plan_id')->constrained()->cascadeOnDelete();
            $t->dateTime('starts_at');
            $t->dateTime('ends_at');
            $t->string('payment_status', 20)->default('paid');
            $t->timestamps();
        });

        Schema::create('contacts', function (Blueprint $t) {
            $t->id();
            $t->string('name', 100);
            $t->string('email', 100);
            $t->text('message');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['contacts','vip_subscriptions','vip_plans','favorites','watch_histories','ratings','comments','actor_movie','actors','episodes','category_movie','movies','categories'] as $t) {
            Schema::dropIfExists($t);
        }
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['role', 'avatar', 'is_active']);
        });
    }
};
