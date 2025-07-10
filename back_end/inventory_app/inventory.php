<?php
// inventory.php
require_once 'includes/db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    $checkedOutItems = $_POST['checkout'];

    foreach ($checkedOutItems as $id) {
        $stmt = $conn->prepare("UPDATE inventory SET checked_out = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    header("Location: inventory.php");
    exit();
}

// Fetch inventory
$result = $conn->query("SELECT * FROM inventory");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
    <style>
        body {
            background-color: #f5f5dc;
            color: #000;
            font-family: Arial, sans-serif;
        }
        table {
            width: 80%;
            margin: 40px auto;
            border-collapse: collapse;
            background-color: #111;
            color: #f5f5dc;
        }
        th, td {
            border: 1px solid #f5f5dc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #222;
        }
        .btn {
            padding: 10px 20px;
            margin: 20px;
            background-color: #000;
            color: #f5f5dc;
            border: 1px solid #f5f5dc;
            cursor: pointer;
        }
        .checked-out {
            text-decoration: line-through;
            color: #888;
        }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Inventory List</h1>
    <form method="POST">
        <table>
            <thead>
                <tr>
                    <th>Check Out</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="<?php echo $row['checked_out'] ? 'checked-out' : ''; ?>">
                        <td>
                            <?php if (!$row['checked_out']): ?>
                                <input type="checkbox" name="checkout[]" value="<?php echo $row['id']; ?>">
                            <?php else: ?>
                                ✓
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['checked_out'] ? 'Checked Out' : 'Available'; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div style="text-align:center;">
            <button type="submit" class="btn">Submit Checkout</button>
        </div>
    </form>
</body>
</html>