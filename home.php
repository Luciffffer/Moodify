<?php

session_start();

if (!isset($_SESSION['access_token'])) {
    header('Location: index.php');
    exit();
}

// first we want to get the users top tracks

// $curl = curl_init();

// curl_setopt_array($curl, [
//     CURLOPT_URL => 'https://api.spotify.com/v1/me/top/tracks?limit=40', // limited to the top 40 tracks
//     CURLOPT_RETURNTRANSFER => 1,
//     CURLOPT_HTTPHEADER => [
//         'Authorization: Bearer ' . $_SESSION['access_token'],
//         'Content-Type: application/x-www-form-urlencoded'
//     ],
//     CURLOPT_HEADER => false
// ]);

// $response = curl_exec($curl);
// curl_close($curl);

// $data = json_decode($response, true);
// $tracks = $data['items'];

// $chosenTrack = $tracks[rand(0, count($tracks) - 1)];

// $curl = curl_init();

// curl_setopt_array($curl, [
//     CURLOPT_URL => 'https://api.spotify.com/v1/me/player/queue?uri=' . $chosenTrack['uri'],
//     CURLOPT_POST => true,
//     CURLOPT_RETURNTRANSFER => 1,
//     CURLOPT_HTTPHEADER => [
//         'Authorization: Bearer ' . $_SESSION['access_token'],
//         'Content-Type: application/x-www-form-urlencoded'
//     ],
//     CURLOPT_HEADER => false
// ]);

// $response = curl_exec($curl);

// curl_close($curl);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moodify</title>
    <link rel="stylesheet" href="style.css">
    <script src="app.js" defer></script>
</head>
<body data-token="<?php echo $_SESSION['access_token']; ?>">
    <a id="logout-btn" href="api/logout.php">Log out</a>
    <h1>Welcome to Moodify</h1>
    <a href="#" id="playpause">Play/Pause</a>
</body>
</html>