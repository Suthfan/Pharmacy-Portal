<html>
<head>
    <title>Inventory</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Medication Inventory</h1>
    <table border="1">
        <tr>
            <th>Medication Name</th>
            <th>Dosage</th>
            <th>Manufacturer</th>
            <th>Quantity Available</th>
        </tr>
        <?php if (empty($inventory)): ?>
            <tr>
                <td colspan="4">No inventory data available.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($inventory as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['medicationName']) ?></td>
                    <td><?= htmlspecialchars($item['dosage']) ?></td>
                    <td><?= htmlspecialchars($item['manufacturer']) ?></td>
                    <td><?= htmlspecialchars($item['quantityAvailable']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <a href="home.php">Back to Dashboard</a>
</body>
</html>
