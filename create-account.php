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
$faker = Faker\Factory::create();

$account = array(
    "name"              => $faker->userAgent,
    "accountUrl"         => $faker->url
);
$account_sync = $ac->api("account", $account);
if (!(int) $account_sync->success) {
    // request failed
    echo "<p>Syncing contact failed. Error returned: " . $account_sync->error . "</p>";
    exit();
}


var_dump($account_sync);
