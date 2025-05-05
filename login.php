<?php
session_start();
require_once 'PharmacyDatabase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = $_POST['username'];
    $password = $_POST['password'];

    $db = new PharmacyDatabase();

    $user = $db->validateUser($userName, $password);
    if ($user) {
        $_SESSION['userId'] = $user['userId'];
        $_SESSION['userName'] = $user['userName'];
        $_SESSION['userType'] = $user['userType'];

        if ($_SESSION['userType'] === 'pharmacist') {
            header("Location: home.php");
        } else {
            header("Location: home.php");
        }
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Pharmacy Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register</a></p>
</body>
</html>
