<?php

use App\Models\DiscordLinkKey;
use App\Models\User;
use Discord\Builders\MessageBuilder;
use Discord\Builders\CommandBuilder;
use Discord\Discord;
use Discord\WebSockets\Intents;
use Discord\Parts\Interactions\Interaction;
use Dotenv\Dotenv;
use Illuminate\Support\Str;
use Illuminate\Contracts\Console\Kernel;

require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel
$app = require __DIR__ . '/../bootstrap/app.php';

// Run Laravel’s kernel to make Eloquent and database available
$app->make(Kernel::class)->bootstrap();

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$discord = new Discord([
    'token' => env('DISCORD_BOT_TOKEN'),
    'intents' => Intents::getAllIntents(),
]);


$discord->on('ready', function (Discord $discord) {
    echo "Bot is ready!\n";

    // Create the linkportal command
    $discord->application->commands->save(
        $discord->application->commands->create(CommandBuilder::new()
            ->setName('linkportal')
            ->setDescription('Link your account to the staff portal')
            ->toArray()
        )
    );

    // Cooldown storage (in memory)
    $cooldowns = [];

    // COMMAND LISTENER
    $discord->listenCommand('linkportal', function (Interaction $interaction) use (&$cooldowns) {
        $appUrl = env('APP_URL');
        $userId = $interaction->user->id; // Get Discord user ID

        //Check if user's discord account is not in the portal's database
        $userExists = User::where('id', '=', $userId)->exists();
        if (!$userExists) {
            return $interaction->respondWithMessage(
                MessageBuilder::new()->setContent("You have not made an account on the **[Staff Portal]({$appUrl})** yet!\n\nPlease first create an account with on the staff portal and then re-run this command to link your account"),
                true
            );
        }

        //Check if the user has already linked their account previously.
        $user = User::where('id', '=', $userId);
        if ($user->account_linked) {
            return $interaction->respondWithMessage(
                MessageBuilder::new()->setContent("You have already linked your account to the **[Staff Portal]({$appUrl})** "),
                true
            );
        }


        $cooldownTime = 60; // Cooldown in seconds (1 minute)

        // Check if the user is in the cooldown array
        if (isset($cooldowns[$userId]) && time() < $cooldowns[$userId]) {
            $remaining = $cooldowns[$userId] - time();
            return $interaction->respondWithMessage(
                MessageBuilder::new()->setContent("You must wait $remaining seconds before using this command again."),
                true
            );
        }


        // Set cooldown expiration time
        $cooldowns[$userId] = time() + $cooldownTime;

        // Generate unique key
        $uniqueKey = Str::random(32);

        // Store key in the database with expiration
        DiscordLinkKey::create([
            'discord_id' => $userId,
            'key' => $uniqueKey,
            'expires_at' => now()->addMinute(),
        ]);

        // Generate linking URL
        $linkUrl = env('APP_URL') . "/discord-link?key={$uniqueKey}";
        session(['linkportal_UID' => $userId]);

        // Respond with the generated link
        $interaction->respondWithMessage(
            MessageBuilder::new()
                ->setContent("# Link your account here \n$linkUrl \n-# (This URL expires in 1 minute)"),
            true
        );
    });
});

$discord->run();
