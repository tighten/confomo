<?php

// You can find the keys here : https://dev.twitter.com/
// Crap, temporary issues with forge
if (file_exists('../.env.forge.php') || file_exists('.env.forge.php')) {
	if (file_exists('../.env.forge.php')) {
		// From web
		$env = include('../.env.forge.php');
	} else {
		// Command line
		$env = include('.env.forge.php');
	}
	$con_key = $env['TWITTER_CONSUMER_KEY'];
	$con_secret = $env['TWITTER_CONSUMER_SECRET'];
	$token = $env['TWITTER_ACCESS_TOKEN'];
	$token_secret = $env['TWITTER_ACCESS_TOKEN_SECRET'];
} else {
	$con_key = getenv('TWITTER_CONSUMER_KEY');
	$con_secret = getenv('TWITTER_CONSUMER_SECRET');
	$token = getenv('TWITTER_ACCESS_TOKEN');
	$token_secret = getenv('TWITTER_ACCESS_TOKEN_SECRET');
}

return array(
	'API_URL'             => 'api.twitter.com',
	'API_VERSION'         => '1.1',
	'USE_SSL'             => true,

	'CONSUMER_KEY'        => $con_key, 
	'CONSUMER_SECRET'     => $con_secret, 
	'ACCESS_TOKEN'        => $token,
	'ACCESS_TOKEN_SECRET' => $token_secret, 
);
