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
        Schema::create('discord_access_tokens', function (Blueprint $collection) {
            // MongoDB doesn't use auto-incrementing IDs like SQL databases, but the _id field is automatically added
            // So we don't need to manually add the $table->id(); line here
            $collection->string('access_token');
            $collection->string('refresh_token');
            $collection->string('token_type');
            $collection->integer('expires_in');
            $collection->timestamp('expires_at');
            $collection->string('scope');
            $collection->foreignId('user_id')->constrained()->cascadeOnDelete(); // You can still use foreign keys in MongoDB but ensure relationships are handled at the application level
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discord_access_tokens');
    }
};
