<?php
require_once 'includes/db.php';
session_start();

$message = "";

// Show message once after redirect
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    !empty($_POST['fullname']) &&
    !empty($_POST['currentpass']) &&
    !empty($_POST['newpass'])
) {
    $fullname = trim($_POST['fullname']);
    $currentPass = trim($_POST['currentpass']);
    $newPassRaw = $_POST['newpass'];
    $newPass = password_hash($newPassRaw, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM customer WHERE fullname = ?");
    if ($stmt) {
        $stmt->bind_param("s", $fullname);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res && $res->num_rows === 1) {
            $user = $res->fetch_assoc();
            if (password_verify($currentPass, $user['password'])) {
                $update = $conn->prepare("UPDATE customer SET password = ? WHERE fullname = ?");
                $update->bind_param("ss", $newPass, $fullname);
                $update->execute();
                $_SESSION['message'] = "Password updated successfully. <a href='login.php'>Login</a>";
            } else {
                $_SESSION['message'] = "Incorrect current password.";
            }
        } else {
            $_SESSION['message'] = "Fullname not found.";
        }
    }

    header("Location: forgot_password.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ✅ Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #000 50%, #f5f5dc 50%);
            font-family: Arial, sans-serif;
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .forgot-box {
            background-color: #1a1a1a;
            padding: 30px;
            border-radius: 10px;
            color: #f5f5dc;
            max-width: 100%;
            width: 350px;
        }
        input[type=text], input[type=password] {
            background: #f5f5dc;
            color: #000;
        }
        input[type=submit] {
            background-color: #000;
            color: #f5f5dc;
        }
        .message {
            margin-bottom: 15px;
            color: #80ff80;
            background-color: #003300;
            padding: 10px;
            border-radius: 5px;
        }
        a {
            color: #f5f5dc;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="forgot-box text-center">
        <h2>Reset Password</h2>

        <?php if (!empty($message)): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3 text-start">
                <label for="fullname" class="form-label fw-bold">Full Name</label>
                <input type="text" class="form-control" name="fullname" required>
            </div>

            <div class="mb-3 text-start">
                <label for="currentpass" class="form-label fw-bold">Current Password</label>
                <input type="password" class="form-control" name="currentpass" required>
            </div>

            <div class="mb-3 text-start">
                <label for="newpass" class="form-label fw-bold">New Password</label>
                <input type="password" class="form-control" name="newpass" required>
            </div>

            <input type="submit" class="btn w-100" value="Reset Password">
        </form>

        <p class="mt-3">
            Back to <a href="login.php">Login</a>
        </p>
    </div>
</body>
</html>
