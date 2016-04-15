<?php

return [

	// Application id to initiate communication with L2P server
	'client_id' => '',
	
	// l2P Urls available to requests
	'base_url' => 'https://oauth.campus.rwth-aachen.de/',
	'user_code_url' => 'oauth2waitress/oauth2.svc/code',
	'access_token_url' => 'oauth2waitress/oauth2.svc/token',

	// User controls on request
	'scope' => 'l2p.rwth userinfo.rwth',
];