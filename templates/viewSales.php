// viewSales.php
<?php
require_once 'PharmacyDatabase.php';

$db = new PharmacyDatabase();
$sales = $db->getSales();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Data</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Sales Data</h1>

<table border="1">
    <thead>
        <tr>
            <th>Sale ID</th>
            <th>Prescription ID</th>
            <th>Sale Date</th>
            <th>Quantity Sold</th>
            <th>Sale Amount</th>
            <th>Dosage Instructions</th>
            <th>Medication Name</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($sales)): ?>
            <tr>
                <td colspan="7">No sales data found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($sales as $sale): ?>
                <tr>
                    <td><?= htmlspecialchars($sale['saleId']) ?></td>
                    <td><?= htmlspecialchars($sale['prescriptionId']) ?></td>
                    <td><?= htmlspecialchars($sale['saleDate']) ?></td>
                    <td><?= htmlspecialchars($sale['quantitySold']) ?></td>
                    <td><?= htmlspecialchars($sale['saleAmount']) ?></td>
                    <td><?= htmlspecialchars($sale['dosageInstructions']) ?></td>
                    <td><?= htmlspecialchars($sale['medicationName']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<a href="home.php">Back to Home</a>
</body>
</html>
