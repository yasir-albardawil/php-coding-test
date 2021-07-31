<?php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('693556136860-6ufphge4rdjkveqh7pkpddoqt75u8j0r.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('1KuirPeEcoT1futtJEat2Atx');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost:8000/google_oauth2.php');

//
$google_client->addScope('email');

$google_client->addScope('profile');
