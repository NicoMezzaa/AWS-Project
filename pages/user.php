<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWS WEBSITE</title>
</head>
<body>
<div class="container" id="content">
    <!-- Il contenuto del README verrà aggiunto qui dinamicamente -->
</div>

<script>
    // Funzione per caricare il contenuto del file README.md
    function loadReadme() {
        const readmeURL = 'https://raw.githubusercontent.com/NicoMezzaa/AWS-Project/main/README.md';

        // Effettua una richiesta HTTP GET per ottenere il contenuto del README.md
        fetch(readmeURL)
            .then(response => response.text())
            .then(text => {
                // Inserisci il contenuto del README.md nel tag con id "content"
                document.getElementById('content').innerHTML = text;
            })
            .catch(error => console.error('Errore nel caricamento del file README.md:', error));
    }

    // Chiamata alla funzione per caricare il contenuto del file README.md al caricamento della pagina
    window.onload = loadReadme;
</script>
</body>
</html>