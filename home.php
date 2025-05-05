<?php
session_start();

if (!isset($_SESSION['userId']) || !isset($_SESSION['userType'])) {
    header("Location: login.php");
    exit();
}

$userName = $_SESSION['userName'];
$userType = $_SESSION['userType'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Pharmacy Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($userName) ?>!</h1>
    <h2>Your Role: <?= htmlspecialchars(ucfirst($userType)) ?></h2>

    <nav>
        <ul>
            <?php if ($userType === 'pharmacist'): ?>
                <li><a href="PharmacyServer.php?action=addPrescription">Add Prescription</a></li>
                <li><a href="PharmacyServer.php?action=viewPrescriptions">View Prescriptions</a></li>
                <li><a href="PharmacyServer.php?action=addMedication">Add Medication</a></li>
                <li><a href="PharmacyServer.php?action=viewInventory">View Inventory</a></li>
                <li><a href="PharmacyServer.php?action=viewSales">View Sales</a></li>
            <?php elseif ($userType === 'patient'): ?>
                <li><a href="PharmacyServer.php?action=viewPrescriptions">My Prescriptions</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
