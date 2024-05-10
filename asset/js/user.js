function typeWriter(textElement, text, speed) {
    let i = 0;
    const interval = setInterval(() => {
        textElement.textContent += text.charAt(i);
        i++;
        if (i >= text.length) {
            clearInterval(interval);
        }
    }, speed);
}

function getUsername() {
    const usernameElement = document.getElementById('username');
    const username = usernameElement.getAttribute('data-username');
    typeWriter(usernameElement, username, 180);
}

window.onload = function() {
    getUsername();
};

function switchTheme() {
    const body = document.body;
    const loginBox = document.querySelector(".container");
    const h1 = document.querySelector("h1");
    const inputs = document.querySelectorAll("input");
    const loginButton = document.getElementById("login-button");
    const h2 = document.querySelector("h2");
    const p = document.querySelector("p");
    const a = document.querySelector("a");

    body.classList.toggle("dark-mode");
    p.classList.toggle("dark-mode");
    a.classList.toggle("dark-mode");
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