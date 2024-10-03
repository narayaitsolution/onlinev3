<?php
session_start();

// Include Librari Google Client (API)
include_once 'template/plugins/google-client/Google_Client.php';
include_once 'template/plugins/google-client/contrib/Google_Oauth2Service.php';

/*
eoffice.saintek.uin-malang.ac.id
$client_id = '238634160161-shhvn547ovee9uvki6n5jq8ufgbi34vc.apps.googleusercontent.com'; // Google client ID
$client_secret = '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'; // Google Client Secret
$redirect_url = 'https://eoffice.saintek.uin-malang.ac.id/authg.php'; // Callback URL
*/

$client_id = '551388806566-9qcpgir2ocn8ku306fir0mbrmgr4kefr.apps.googleusercontent.com'; // Google client ID
$client_secret = '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'; // Google Client Secret
$redirect_url = 'http://localhost/onlinev3/authg.php'; // Callback URL

// Call Google API
$gclient = new Google_Client();
$gclient->setClientId($client_id); // Set dengan Client ID
$gclient->setClientSecret($client_secret); // Set dengan Client Secret
$gclient->setRedirectUri($redirect_url); // Set URL untuk Redirect setelah berhasil login

$google_oauthv2 = new Google_Oauth2Service($gclient);
