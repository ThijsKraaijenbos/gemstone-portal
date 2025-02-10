<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiscordLinkController extends Controller
{
    public function index(Request $request) {
        dump($request);
        return view('discord-link');
    }
}
