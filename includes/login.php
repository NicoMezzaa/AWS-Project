<?php
include 'connect.php';

session_start();    // avvio della sessione

// verifica se è stata data email e password attraverso il metodo POST
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
        echo "Login riuscito!".'<br/>';
		echo "Benvenuto ". $_SESSION['username'] . '!';
    } else {
        echo "Credenziali errate. Login fallito!";
    }
    $conn->close();
}
?>