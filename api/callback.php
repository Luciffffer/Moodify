<?php

require_once '../config.php';

session_start();

if (isset($_GET['code']) && !empty($_GET['code'])) {

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://accounts.spotify.com/api/token',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => 'grant_type=authorization_code&code=' . $_GET['code'] . '&redirect_uri=' . urlencode('http://localhost/moodify/api/callback.php'),
        CURLOPT_USERPWD => CLIENT_ID . ':' . CLIENT_SECRET,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HEADER => [
            'Content-Type: application/x-www-form-urlencoded'
        ],
        CURLOPT_HEADER => false
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);

    $_SESSION['access_token'] = $data['access_token'];
    $_SESSION['refresh_token'] = $data['refresh_token'];
    $_SESSION['expires_in'] = $data['expires_in'];

    header('Location: ../home.php');

} else {
    header('Location: index.php');
}
