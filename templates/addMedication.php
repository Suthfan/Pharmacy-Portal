<?php
require_once 'PharmacyDatabase.php';
$db = new PharmacyDatabase();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicationName = $_POST['medication_name'];
    $dosage = $_POST['dosage'];
    $manufacturer = $_POST['manufacturer'];
    if ($db->addMedication($medicationName, $dosage, $manufacturer)) {
        echo "<p>Medication added successfully.</p>";
    } else {
        echo "<p>Failed to add medication. Please try again.</p>";
    }
}
?>
<html>

<head>
    <title>Add Medication</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Add Medication</h1>
    <form method="POST" action="?action=addMedication">
        <label for="medication_name">Medication Name:</label>
        <input type="text" id="medication_name" name="medication_name" required /><br>
        <label for="dosage">Dosage:</label>
        <input type="text" id="dosage" name="dosage" required /><br>
        <label for="manufacturer">Manufacturer:</label>
        <input type="text" id="manufacturer" name="manufacturer" required /><br>
        <button type="submit">Add Medication</button>
    </form>
    <a href="home.php">Back to Dashboard</a>
</body>

</html>
