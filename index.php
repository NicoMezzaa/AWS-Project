<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        #login-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #login-box input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #login-box button {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div id="login-box">
        <h2>Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
    <?php
    // Verifica le credenziali e mostra un messaggio di benvenuto se l'autenticazione ha successo
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = "admin"; // Imposta l'username valido
        $password = "password"; // Imposta la password valida

        if ($_POST["username"] === $username && $_POST["password"] === $password) {
            echo "<p>Benvenuto, $username!</p>";
        } else {
            echo "<p>Credenziali non valide. Riprova.</p>";
        }
    }
    ?>
</body>
</html>