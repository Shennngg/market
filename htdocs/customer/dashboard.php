<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['fullname'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5dc;
            color: #000;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .card {
            background-color: #000;
            color: #f5f5dc;
            border: none;
            border-radius: 10px;
            padding: 20px;
        }
        .logout {
            text-align: right;
            margin-top: 20px;
        }
        .logout a {
            color: #f5f5dc;
            background-color: #000;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #f5f5dc;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
        <h1 class="mb-4">Welcome, <?= htmlspecialchars($_SESSION['fullname']) ?>!</h1>

        <div class="card">
            <h4>User Details</h4>
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
            <p><strong>Contact:</strong> <?= htmlspecialchars($_SESSION['contact']) ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($_SESSION['address']) ?></p>
            <p><strong>Role:</strong> <?= htmlspecialchars($_SESSION['role']) ?></p>
        </div>
    </div>
</body>
</html>
