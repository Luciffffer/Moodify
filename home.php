<?php

session_start();

if (!isset($_SESSION['access_token'])) {
    header('Location: index.php');
    exit();
}

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
    <h1>Welcome to <span class="green-text">Moodify</span></h1>
    
</body>
</html>