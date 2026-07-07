<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="login-box">
<h2>LOGIN</h2>

<form action="proses_login.php" method="POST">

    Email
    <br>
    <input type="email" name="email" required>
    <br><br>

    Password
    <br>
    <input type="password" name="password" required>
    <br><br>

    <button type="submit">
        Login
    </button>

</form>

</body>
</html>