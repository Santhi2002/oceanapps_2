<?php
define('GOOGLE_CLIENT_ID', '243242718602-5dt9f23abg8uab9blu124fkeivo1c172.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URL', 'http://localhost/oceanerp/');

require_once './plugins/google-api-php-client/Google_Client.php';
require_once './plugins/google-api-php-client/contrib/Google_Oauth2Service.php';


$gClient = new Google_Client();
$gClient->setApplicationName('Login to oceanapps.in');
$gClient->setClientId(GOOGLE_CLIENT_ID);
$gClient->setClientSecret(GOOGLE_CLIENT_SECRET);
$gClient->setRedirectUri(GOOGLE_REDIRECT_URL);
$gClient->setAccessType('offline');
$google_oauthV2 = new Google_Oauth2Service($gClient);