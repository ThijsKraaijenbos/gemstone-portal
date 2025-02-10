<?php

require __DIR__ . '/../vendor/autoload.php';

use Discord\Builders\MessageBuilder;
use Discord\Builders\CommandBuilder;
use Discord\Discord;
use Discord\WebSockets\Intents;
use Discord\Parts\Interactions\Interaction;

use Dotenv\Dotenv;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$discord = new Discord([
    'token' => env('DISCORD_BOT_TOKEN'),
    'intents' => Intents::getAllIntents(),
]);


$discord->on('ready', function (Discord $discord) {
    echo "Bot is ready!\n";

    $discord->application->commands->save(
        $linkCommand = $discord->application->commands->create(CommandBuilder::new()
            ->setName('linkportal')
            ->setDescription('Link your account to the staff portal')
            ->toArray()
        )
    );

    //    COMMAND LISTENER ->
    $discord->listenCommand('linkportal', function (Interaction $interaction) {
        $userId = $interaction->user->id; // Get Discord user ID
        $uniqueKey = Str::random(32); // Generate a 32-character unique key

        // Store the key in the database with an expiration time (e.g., 15 minutes)
        DB::table('discord_link_keys')->insert([
            'discord_id' => $userId,
            'key' => $uniqueKey,
            'expires_at' => now()->addMinutes(15), // Expiration time
        ]);

        // Generate the linking URL
        $linkUrl = env('APP_URL') . "/discord-link?key={$uniqueKey}";


        // Respond with the generated link
        $interaction->respondWithMessage(MessageBuilder::new()->setContent("Link your account here: $linkUrl (expires in 15 minutes)"));
    });
});

$discord->run();
