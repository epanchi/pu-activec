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

$list_id = 1;

$message = array(
    "format"        => "mime",
    "subject"       => "Check out our latest deals!",
    "fromemail"     => "newsletter@test.com",
    "fromname"      => "Test from API",
    "html"          => "<p>My email newsletter.</p>",
    "p[{$list_id}]" => $list_id,
);

$message_add = $ac->api("message/add", $message);

if (!(int) $message_add->success) {
    // request failed
    echo "<p>Adding email message failed. Error returned: " . $message_add->error . "</p>";
    exit();
}

// successful request
$message_id = (int) $message_add->id;
echo "<p>Message added successfully (ID {$message_id})!</p>";

$campaign = array(
    "type"             => "single",
    "name"             => "July Campaign", // internal name (message subject above is what contacts see)
    "sdate"            => "2013-07-01 00:00:00",
    "status"           => 1,
    "public"           => 1,
    "tracklinks"       => "all",
    "trackreads"       => 1,
    "htmlunsub"        => 1,
    "p[{$list_id}]"    => $list_id,
    "m[{$message_id}]" => 100, // 100 percent of subscribers
);

$campaign_create = $ac->api("campaign/create", $campaign);

if (!(int) $campaign_create->success) {
    // request failed
    echo "<p>Creating campaign failed. Error returned: " . $campaign_create->error . "</p>";
    exit();
}

// successful request
$campaign_id = (int) $campaign_create->id;
echo "<p>Campaign created and sent! (ID {$campaign_id})!</p>";
