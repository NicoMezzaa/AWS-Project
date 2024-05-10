<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWS website</title>
    <link rel="stylesheet" href="../asset/css/style_user.css">
    <style>
        /* Stile per l'animazione di scrittura */
        #username::after {
            content: "|"; /* Carattere di cursore lampeggiante */
            animation: blink-caret 0.75s step-end infinite;
        }

        /* Animazione di lampeggiamento */
        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: black; }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Bentornato, <span id="username"></span></h1>
    <p>Benvenuto nel sito realizzato su AWS.</p>
    <p>Puoi trovare maggiori dettagli nel <a href="https://github.com/NicoMezzaa/AWS-Project/edit/main/README.md" target="_blank">README</a>.</p>
</div>

<script>
    // Funzione per ottenere lo username
    function getUsername() {
        // Sostituisci questo valore con il vero username ottenuto dal tuo sistema
        const username = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Username'; ?>"; 
        const usernameElement = document.getElementById('username');

        // Funzione per simulare la digitazione
        function typeWriter(textElement, text, speed) {
            let i = 0;
            const interval = setInterval(() => {
                textElement.textContent += text.charAt(i);
                i++;
                if (i > text.length) {
                    clearInterval(interval);
                    // Rimuovi il cursore lampeggiante
                    textElement.style.animation = 'none';
                }
            }, speed);
        }

        // Chiama la funzione per simulare la digitazione
        typeWriter(usernameElement, username, 180);
    }

    // Chiama la funzione per ottenere lo username quando la pagina è completamente caricata
    window.onload = getUsername;
</script>

</body>
</html>