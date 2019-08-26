<?php

include('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::create(__DIR__, '.env');
$dotenv->load();



$response = file_get_contents(getenv('ACTIVE_CAMPAIGN_URL'));
var_dump(json_decode($response));
