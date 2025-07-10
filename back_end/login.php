<?php
session_start();
require_once 'includes/db.php';

$error = "";
$rememberedUsername = $_COOKIE['remember_username'] ?? '';
$rememberedPassword = $_COOKIE['remember_password'] ?? '';

// Handle login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    $stmt = $conn->prepare("SELECT * FROM customer WHERE fullname = ?");
    $stmt->bind_param("s", $fullname);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Set session
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['contact'] = $row['contact'];
            $_SESSION['address'] = $row['address'];
            $_SESSION['role'] = 'customer';

            // If "Remember Me" checked
            if ($remember) {
                setcookie("remember_username", $fullname, time() + (86400 * 30), "/");
                setcookie("remember_password", $password, time() + (86400 * 30), "/");
            } else {
                // Clear cookies if unchecked
                setcookie("remember_username", "", time() - 3600, "/");
                setcookie("remember_password", "", time() - 3600, "/");
            }

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #000 50%, #f5f5dc 50%);
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .login-box {
            background-color: #1a1a1a;
            padding: 30px;
            border-radius: 10px;
            color: #f5f5dc;
            width: 100%;
            max-width: 400px;
        }
        input[type=text], input[type=password] {
            background: #f5f5dc;
            color: #000;
        }
        .password-container {
            position: relative;
        }
        .password-container input {
            padding-right: 40px;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #000;
        }
        .error {
            background: #330000;
            color: #ff8080;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2 class="text-center">Login</h2>

    <?php if (!empty($error)) : ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($rememberedUsername) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="password-container">
                <input type="password" name="password" id="password" class="form-control" required value="<?= htmlspecialchars($rememberedPassword) ?>">
                <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
            </div>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                   <?= $rememberedUsername ? 'checked' : '' ?>>
            <label class="form-check-label" for="remember">Remember Me</label>
        </div>

        <input type="submit" value="Login" class="btn btn-dark w-100">
    </form>

    <div class="text-center mt-4">
        <p><a href="register.php">Register</a></p>
        <p><a href="forgot_password.php">Forgot Password?</a></p>
    </div>
</div>

<script>
    document.getElementById("togglePassword").addEventListener("click", function () {
        const password = document.getElementById("password");
        if (password.type === "password") {
            password.type = "text";
            this.classList.remove("bi-eye-slash");
            this.classList.add("bi-eye");
        } else {
            password.type = "password";
            this.classList.remove("bi-eye");
            this.classList.add("bi-eye-slash");
        }
    });
</script>

</body>
</html>
