<?php

// You can find the keys here : https://dev.twitter.com/

return array(
	'API_URL'             => 'api.twitter.com',
	'API_VERSION'         => '1.1',
	'USE_SSL'             => true,

	'CONSUMER_KEY'        => getenv('TWITTER_CONSUMER_KEY'),
	'CONSUMER_SECRET'     => getenv('TWITTER_CONSUMER_SECRET'),
	'ACCESS_TOKEN'        => getenv('TWITTER_ACCESS_TOKEN'),
	'ACCESS_TOKEN_SECRET' => getenv('TWITTER_ACCESS_TOKEN_SECRET'),
);