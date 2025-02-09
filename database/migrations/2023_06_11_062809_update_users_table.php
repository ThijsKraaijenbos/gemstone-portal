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
        Schema::table('users', function (Blueprint $collection) {
            // Adding new fields
            $collection->string('global_name')->nullable(); // Nullable string field
            $collection->string('discriminator')->nullable(); // Changing the discriminator field to nullable
            $collection->string('banner')->nullable(); // Nullable string field
            $collection->string('banner_color')->nullable(); // Nullable string field
            $collection->string('accent_color')->nullable(); // Nullable string field
            $collection->string('premium_type')->nullable(); // Nullable string field
            $collection->string('public_flags')->nullable(); // Nullable string field
            $collection->boolean('verified')->nullable(); // Nullable boolean field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $collection) {
            // Dropping columns
            $collection->dropColumn('global_name');
            $collection->dropColumn('banner');
            $collection->dropColumn('banner_color');
            $collection->dropColumn('accent_color');
            $collection->dropColumn('premium_type');
            $collection->dropColumn('public_flags');
            $collection->dropColumn('verified');
        });
    }
};
