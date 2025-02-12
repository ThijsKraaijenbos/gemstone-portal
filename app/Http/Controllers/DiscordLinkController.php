<?php

namespace App\Http\Controllers;

use App\Models\DiscordLinkKey;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiscordLinkController extends Controller
{
    public function index(Request $request) {
        $key = DiscordLinkKey::where('key', $request['key'])->first();

        if (!$key) {
            abort(404);
        }

        if ($key->expires_at < Carbon::now()) {
            return view('login')->with(['message' => 'This linking URL has expired. Please re-attempt to link by running /linkportal again']);
        }

        try {
            $userId = $key->discord_id;
            $user = User::where('id', $userId)->first();
            $user->account_linked = true;
            $user->save();
            return view('dashboard')->with(['message' => 'Valid linking key :D']);
        } catch(\Exception $e) {
            return view('login')->with(['message' => $e->getMessage()]);
        }


    }
}
