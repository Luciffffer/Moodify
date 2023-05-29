<?php

require_once 'config.php';

session_start();

if (isset($_SESSION['access_token'])) {
    header('Location: home.php');
    exit();
}

if (isset($_POST['login'])) {
    // if login button is pressed we want to redirect to the spotify login page
    $redirectUri = "http://localhost/moodify/api/callback.php"; // login page will redirect to the callback page
    $scopes = "user-library-read streaming user-modify-playback-state user-read-playback-state user-top-read"; // permissions we want from the user

    $auth_url = 'https://accounts.spotify.com/authorize?response_type=code&client_id=' . CLIENT_ID . '&scope=' . urlencode($scopes) . '&redirect_uri=' . urlencode($redirectUri); 
    header('Location: ' . $auth_url);
    exit();
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Moodify</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="login-top-text">
        <img class="logo" src="assets/images/moodify.svg" alt="Moodify logo">
        <p>A platform that plays songs depending on how you are feeling</p>
    </div>
    <form action="" method="POST">
        <button type="submit" name="login" class="button">Login with Spotify</button>
    </form>
</body>
</html>