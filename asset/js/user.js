// Funzione per ottenere lo username dallato PHP e scriverlo nell'elemento span
function getUsername() {
    const usernameElement = document.getElementById('username');
    const username = usernameElement.textContent;

    if (username === '') { // Controllo se lo username è vuoto
        const sessionUsername = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Username'; ?>";
        typeWriter(usernameElement, sessionUsername, 180);
    }
}

// Funzione per animare la scrittura del testo
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

// Funzione per attivare/disattivare la modalità scura
function switchTheme() {
    const body = document.body;
    const container = document.querySelector(".container");
    const h1 = document.querySelector("h1");
    const inputs = document.querySelectorAll("input");
    const loginButton = document.getElementById("login-button");
    const h2 = document.querySelector("h2");
    const p = document.querySelector("p");
    const a = document.querySelector("a");

    body.classList.toggle("dark-mode");
    container.classList.toggle("dark-mode");
    h1.classList.toggle("dark-mode");
    inputs.forEach(input => {
        input.classList.toggle("dark-mode");
    });
    loginButton.classList.toggle("dark-mode");
    p.classList.toggle("dark-mode");
    a.classList.toggle("dark-mode");
    if (h2) { // Controllo se h2 esiste
        h2.classList.toggle("dark-mode");
    }
}

// Carica la funzione getUsername() quando la pagina è completamente caricata
window.onload = function() {
    getUsername();
};