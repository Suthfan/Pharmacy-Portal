<?php
session_start();
require_once 'PharmacyDatabase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = $_POST['user_name'];
    $contactInfo = $_POST['contact_info'];
    $userType = $_POST['user_type'];
    $password = $_POST['password'];
    $db = new PharmacyDatabase();
    $db->addUser($userName, $contactInfo, $userType, $password);
    $_SESSION['userName'] = $userName;
    $_SESSION['userType'] = $userType;
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Pharmacy Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h1>Register</h1>
    <form method="POST" action="register.php">
        User Name: <input type="text" name="user_name" required><br>
        Contact Info: <input type="text" name="contact_info" required><br>
        User Type:
        <select name="user_type" required>
            <option value="pharmacist">Pharmacist</option>
            <option value="patient">Patient</option>
        </select><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</body>

</html>