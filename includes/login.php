<?php
include 'connect.php';

session_start();    // avvio della sessione

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    echo "vattene via";
} else {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $password = md5($password);

    // query per verificare se l'utente esiste gia nel database
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['logged'] = true;
        $_SESSION['username'] = $username;
        header("Location: ../pages/user.php");
    } else {
        $_SESSION['error_message'] = "Credenziali errate. Login fallito!";
        header("Location: ../pages/login.php");
    }
    $conn->close();
}