<?php
session_start();

// Include Librari Google Client (API)
include_once 'template/plugins/google-client/Google_Client.php';
include_once 'template/plugins/google-client/contrib/Google_Oauth2Service.php';

$client_id = '551388806566-9qcpgir2ocn8ku306fir0mbrmgr4kefr.apps.googleusercontent.com'; // Google client ID
$client_secret = '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'; // Google Client Secret
$redirect_url = 'http://localhost/onlinev3/authg.php'; // Callback URL

// Call Google API
$gclient = new Google_Client();
$gclient->setClientId($client_id); // Set dengan Client ID
$gclient->setClientSecret($client_secret); // Set dengan Client Secret
$gclient->setRedirectUri($redirect_url); // Set URL untuk Redirect setelah berhasil login

$google_oauthv2 = new Google_Oauth2Service($gclient);
