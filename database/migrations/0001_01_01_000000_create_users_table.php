<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;

return new class extends Migration
{
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Users Collection
        Schema::create('users', function (Blueprint $collection) {
            $collection->index('username');  // Indexing username
            $collection->index('discriminator');  // Indexing discriminator
            $collection->string('username');
            $collection->string('discriminator');
            $collection->string('email')->nullable()->unique();
            $collection->string('avatar')->nullable();
            $collection->boolean('verified');
            $collection->string('locale');
            $collection->boolean('mfa_enabled');
            $collection->string('refresh_token')->nullable();
            $collection->timestamps();  // MongoDB will handle this automatically
        });

        // Password Reset Tokens Collection
        Schema::create('password_reset_tokens', function (Blueprint $collection) {
            $collection->primary('email');
            $collection->string('email');
            $collection->string('token');
            $collection->timestamp('created_at')->nullable();
        });

        // Sessions Collection
        Schema::create('sessions', function (Blueprint $collection) {
            $collection->primary('id');
            $collection->string('id');
            $collection->index('user_id'); // Indexing user_id
            $collection->foreignId('user_id')->nullable();
            $collection->string('ip_address', 45)->nullable();
            $collection->text('user_agent')->nullable();
            $collection->longText('payload');
            $collection->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
