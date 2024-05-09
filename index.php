<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/asset/css/style_index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div id="login-box">
        <h2>Login</h2>
        <form method="post" action="/includes/login.php">
            <div style="position: relative;">
                <i class="fas fa-user icon"></i>
                <input type="text" name="username" maxlength="30" placeholder="Username" required>
            </div>
            <div style="position: relative;">
                <i class="fas fa-lock icon"></i>
                <input type="password" name="password" minlength="8" maxlength="16" placeholder="Password" required>
                <span class="password-icon"><i class="fas fa-eye"></i></span>
            </div>
            <button type="submit">Login</button>
            <div class="form-border"></div>
        </form>
    </div>
</body>
</html>