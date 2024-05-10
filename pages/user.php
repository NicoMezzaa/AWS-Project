<?php
session_start();

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWS website</title>
    <link rel="stylesheet" href="../asset/css/style_user.css">
    <link rel="icon" href="../asset/img/aws_logo.png" type="image/x-icon">
</head>

<body>
    <div class="container">
        <h1>Bentornato, <span id="username"></span></h1>
        <p>Benvenuto nel sito realizzato su AWS.
            Puoi trovare maggiori dettagli, <a href="https://github.com/NicoMezzaa/AWS-Project" id="github-link" target="_blank">Clicca qui</a>.</p>
    </div>

    <div class="theme-toggle">
        <h2></h2>
        <label class="switch">
            <input type="checkbox" onclick="switchTheme()">
            <span class="slider"></span>
        </label>
    </div>

    <script src="../asset/js/user.js"></script>

</body>

</html>