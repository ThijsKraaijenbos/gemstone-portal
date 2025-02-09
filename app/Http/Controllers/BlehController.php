<?php

namespace App\Http\Controllers;

use App\Models\Blah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use \Illuminate\Support\Facades\Log;

class BlehController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $testData = Blah::all();

//        $userId = 345612501649588224; // ID of the logged-in user
//        $accessToken = $user->access_token['access_token']; // The access token from OAuth2

//        $roles = $this->getUserRoles($userId, $guildId, $accessToken);
//
//        if ($roles) {
//            return "bleh";
//        } else {
//            echo "Failed to fetch roles or user doesn't have roles in the guild.";
//        }

       $guildId = "1269743228115222610"; // ID of the gemstone staff discord

        try {
            $guildMember = $user->getGuildMember($guildId);

            dd($guildMember);
            /*
                {
                    "avatar": null,
                    "joined_at": "2023-01-04T09:26:07.172000Z",
                    "nick": "My Server Nickname",
                    "roles": [
                        "1082025544411000832"
                    ],
                    "deaf": false,
                    "mute": false
                }
            */
        } catch (\Exception $exception) {
            dd('Something went wrong.' . $exception->getMessage());
        }

        return view('test', compact('testData', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Blah::create([
            'name' => 'test',
            'description' => 'ur mom',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



//    public function getUserRoles($userId, $guildId, $accessToken)
//    {
//        // Send a GET request to fetch the user's guild membership data
//        $response = Http::withToken("bot " . $accessToken)
//            ->get("https://discord.com/api/v10/guilds/{$guildId}/members/{$userId}");
//
//        // Check if the request was successful
//        if ($response->successful()) {
//            // Dump the response to inspect it
//
//            // Retrieve the list of roles for the user
//            $roles = $response->json()['roles'];
//
//            // Store roles in an array for later use
//            return $roles;
//        } else {
//            // Handle the error if the request fails
//            return null;
//        }
//    }



}
