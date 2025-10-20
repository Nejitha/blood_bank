<?php
include 'db.php';
session_start();

$error = "";

// When hospital submits the login form
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM hospitals WHERE username='$username' AND password='$password'";
    $res = mysqli_query($conn, $sql);

    if (!$res) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($res) == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['hospital'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid Username or Password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Hospital Login</title>
<style>
    body {
        font-family: "Poppins", sans-serif;
        background: linear-gradient(135deg, #ffe6eb, #fff5f7);
        height: 100vh;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-box {
        background: #fff;
        padding: 40px 35px;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        width: 360px;
        text-align: center;
    }

    .login-box h2 {
        color: crimson;
        margin-bottom: 25px;
    }

    input[type="text"], input[type="password"] {
        width: 90%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
    }

    button {
        background: crimson;
        color: white;
        border: none;
        padding: 10px 20px;
        margin-top: 15px;
        border-radius: 8px;
        cursor: pointer;
        width: 95%;
        font-size: 16px;
        transition: background 0.3s;
    }

    button:hover {
        background: darkred;
    }

    .error {
        color: red;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .back-link {
        display: inline-block;
        margin-top: 15px;
        color: #555;
        text-decoration: none;
        font-size: 14px;
    }

    .back-link:hover {
        color: crimson;
        text-decoration: underline;
    }

    .icon {
        font-size: 45px;
        color: crimson;
        margin-bottom: 10px;
    }
</style>
</head>
<body>

<div class="login-box">
    <div class="icon">🏥</div>
    <h2>Hospital Login</h2>

    <?php if ($error) echo "<div class='error'>$error</div>"; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Enter Username" required><br>
        <input type="password" name="password" placeholder="Enter Password" required><br>
        <button type="submit" name="login">Login</button>
    </form>

    <a href="public_view.php" class="back-link">← Back to Donor List</a>
</div>

</body>
</html>