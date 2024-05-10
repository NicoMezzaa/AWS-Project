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
    <p>Benvenuto nel sito realizzato su AWS.</p>
    <p>Puoi trovare maggiori dettagli, <a href="https://github.com/NicoMezzaa/AWS-Project" id="github-link" target="_blank">Clicca qui</a>.</p>
</div>

<div class="theme-toggle">
    <h2></h2>
    <label class="switch">
      <input type="checkbox" onclick="switchTheme()">
      <span class="slider"></span>
    </label>
  </div>

<script>
    function getUsername() {
        const username = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Username'; ?>"; 
        const usernameElement = document.getElementById('username');

        function typeWriter(textElement, text, speed) {
            let i = 0;
            const interval = setInterval(() => {
                textElement.textContent += text.charAt(i);
                i++;
                if (i > text.length) {
                    clearInterval(interval);
                    textElement.style.animation = 'none';
                }
            }, speed);
        }

        typeWriter(usernameElement, username, 180);
    }

    function switchTheme() {
        const body = document.body;
        const loginBox = document.querySelector(".container");
        const h1 = document.querySelector("h1");
        const inputs = document.querySelectorAll("input");
        const loginButton = document.getElementById("login-button");
        const h2 = document.querySelector("h2");
        const p = document.querySelector("p");

        body.classList.toggle("dark-mode");
        p.classList.toggle("dark-mode");
        loginBox.classList.toggle("dark-mode");
        h1.classList.toggle("dark-mode");
        inputs.forEach(input => {
            input.classList.toggle("dark-mode");
        });
        loginButton.classList.toggle("dark-mode");
        if (h2) { // Controllo se h2 esiste
            h2.classList.toggle("dark-mode");
        }
    }

    window.onload = function() {
        getUsername();
    };
</script>

</body>
</html>