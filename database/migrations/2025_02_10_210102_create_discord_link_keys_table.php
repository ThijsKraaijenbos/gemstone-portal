<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('discord_link_keys', function (Blueprint $table) {
            $table->id();
            $table->string('discord_id'); // Discord user ID
            $table->string('key')->unique(); // Unique linking key
            $table->timestamp('expires_at'); // Expiration timestamp
            $table->timestamps(); // Created_at and updated_at
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('discord_link_keys');
    }
};

