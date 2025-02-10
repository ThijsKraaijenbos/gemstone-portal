<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscordLinkKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'discord_id',
        'key',
        'expires_at'
    ];

    public $timestamps = true;
}

