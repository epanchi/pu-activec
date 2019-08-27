<?php

include('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::create(__DIR__, '.env');
$dotenv->load();
$ac = new ActiveCampaign(getenv('ACTIVECAMPAIGN_URL'), getenv('ACTIVECAMPAIGN_KEY'));

/*
	 * TEST API CREDENTIALS.
	 */

if (!(int) $ac->credentials_test()) {
    echo "<p>Access denied: Invalid credentials (URL and/or API key).</p>";
    exit();
}

echo "<p>Credentials valid! Proceeding...</p>";

/*
	 * VIEW ACCOUNT DETAILS.
	 */

$account = $ac->api("account/view");

echo "<pre>";
print_r($account);
echo "</pre>";

$faker = Faker\Factory::create();

// generate data by accessing properties
echo $faker->name;

?>
<script type="text/javascript">
    (function(e, t, o, n, p, r, i) {
        e.visitorGlobalObjectAlias = n;
        e[e.visitorGlobalObjectAlias] = e[e.visitorGlobalObjectAlias] || function() {
            (e[e.visitorGlobalObjectAlias].q = e[e.visitorGlobalObjectAlias].q || []).push(arguments)
        };
        e[e.visitorGlobalObjectAlias].l = (new Date).getTime();
        r = t.createElement("script");
        r.src = o;
        r.async = true;
        i = t.getElementsByTagName("script")[0];
        i.parentNode.insertBefore(r, i)
    })(window, document, "https://diffuser-cdn.app-us1.com/diffuser/diffuser.js", "vgo");
    vgo('setAccount', '610264226');
    vgo('setTrackByDefault', true);

    vgo('process');
</script>