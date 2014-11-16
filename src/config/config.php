<?php

return array(
	// The URL of the FreeGeoIP API
	'freegeoipURL' => 'http://www.freegeoip.net/json/',
	
	// Timeout when calling the API (in seconds)
	'timeout' => 30,
	
	// IP address overrides. Defaults localhost to Google
	'overrides' => array(
	  '127.0.0.1' => '64.233.160.0',
	  'localhost' => '64.233.160.0',
	)
);
