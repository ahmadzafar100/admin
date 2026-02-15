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
        Schema::create('users', function (Blueprint $table) {
            $table->engine('innoDB');
            $table->id();
            $table->string('name', 50);
            $table->string('email', 100);
            $table->tinyInteger('email_verified')->default(0);
            $table->string('mobile', 10);
            $table->tinyInteger('mobile_verified')->default(0);
            $table->string('username', 50);
            $table->string('password', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
