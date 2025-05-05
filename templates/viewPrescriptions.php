<html>
<head><title>View Prescriptions</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>All Prescriptions</h1>
    <table border="1">
        <tr>
            <th>Prescription ID</th>
            <th>User ID</th>
            <th>Medication ID</th>
            <th>Medication Name</th>
            <th>Dosage Instructions</th>
            <th>Quantity</th>
        </tr>
        <?php if (empty($prescriptions)): ?>
            <tr>
                <td colspan="6">No prescriptions found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($prescriptions as $prescription): ?>
                <tr>
                    <td><?= htmlspecialchars($prescription['prescriptionId']) ?></td>
                    <td><?= htmlspecialchars($prescription['userId']) ?></td>
                    <td><?= htmlspecialchars($prescription['medicationId']) ?></td>
                    <td><?= htmlspecialchars($prescription['medicationName']) ?></td>
                    <td><?= htmlspecialchars($prescription['dosageInstructions']) ?></td>
                    <td><?= htmlspecialchars($prescription['quantity']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <a href="home.php">Back to Home</a>
</body>
</html>
