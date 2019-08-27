<?php

include('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::create(__DIR__, '.env');
$dotenv->load();

$ac = new ActiveCampaign(getenv('ACTIVECAMPAIGN_URL'), getenv('ACTIVECAMPAIGN_KEY'));

// VALIDATE ACCESS

if (!(int) $ac->credentials_test()) {
    echo "<p>Access denied: Invalid credentials (URL and/or API key).</p>";
    exit();
}

$listId = 1;

$faker = Faker\Factory::create();

for ($i = 0; $i < 2; $i++) {
    $contact = array(
        "email"              => $faker->email,
        "first_name"         => $faker->firstName,
        "last_name"          => $faker->lastName,
        "p[{$listId}]"      => $listId,
        "status[{$listId}]" => 1, // "Active" status
    );
    $contact_sync = $ac->api("contact/sync", $contact);
    if (!(int) $contact_sync->success) {
        // request failed
        echo "<p>Syncing contact failed. Error returned: " . $contact_sync->error . "</p>";
        exit();
    }
    // successful request
    $contact_id = (int) $contact_sync->subscriber_id;
    echo "<p>Contact synced successfully (ID {$contact_id})!</p>";
}
