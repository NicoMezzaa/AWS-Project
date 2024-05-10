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
    <h1 style="font-size: 2.5em; color: #ffffff; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Bentornato, <span id="username"></span></h1>
    <p>Benvenuto nel sito realizzato su AWS.</p>
    <p>Puoi trovare maggiori dettagli, <a href="https://github.com/NicoMezzaa/AWS-Project/edit/main" target="_blank">Clicca qui</a>.</p>
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

    window.onload = getUsername;
</script>

</body>
</html>