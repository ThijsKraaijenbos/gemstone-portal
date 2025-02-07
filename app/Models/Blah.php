<?php
namespace App\Models;
use MongoDB\Laravel\Eloquent\Model;
class Blah extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
}
