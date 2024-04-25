<?php
session_start();

// Include Librari Google Client (API)
include_once 'template/plugins/google-client/Google_Client.php';
include_once 'template/plugins/google-client/contrib/Google_Oauth2Service.php';

$client_id = '238634160161-83o4frumk38h8va3t68cu0e9s7tm4rsp.apps.googleusercontent.com'; // Google client ID
$client_secret = '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'; // Google Client Secret
$redirect_url = 'http://localhost/onlinev3/authgoogle.php'; // Callback URL

// Call Google API
$gclient = new Google_Client();
$gclient->setClientId($client_id); // Set dengan Client ID
$gclient->setClientSecret($client_secret); // Set dengan Client Secret
$gclient->setRedirectUri($redirect_url); // Set URL untuk Redirect setelah berhasil login

$google_oauthv2 = new Google_Oauth2Service($gclient);
