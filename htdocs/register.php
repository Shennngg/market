<?php
require_once 'includes/db.php';
session_start();

$message = "";

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // ✅ Email must end with @gmail.com
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
        $_SESSION['message'] = "Email must be a valid @gmail.com address.";
        header("Location: register.php");
        exit;
    }

    // ✅ Contact number must be exactly 11 digits
    if (!preg_match('/^[0-9]{11}$/', $contact)) {
        $_SESSION['message'] = "Phone number must be exactly 11 digits.";
        header("Location: register.php");
        exit;
    }

    // ✅ Passwords must match
    if ($password !== $confirm_password) {
        $_SESSION['message'] = "Passwords do not match.";
        header("Location: register.php");
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO customer (fullname, address, email, contact, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fullname, $address, $email, $contact, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Registration successful. <a href='login.php'>Login here</a>.";
    } else {
        $_SESSION['message'] = "Registration failed or email already exists.";
    }

    header("Location: register.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register New Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #000 50%, #f5f5dc 50%);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .register-box {
            background-color: #1e1e1e;
            padding: 30px 35px;
            border-radius: 12px;
            width: 350px;
            box-shadow: 0 0 10px rgba(0,0,0,0.4);
            color: #f5f5dc;
        }

        .register-box h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 22px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            background-color: #f5f5dc;
            color: #000;
            border: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn-submit {
            background-color: #000;
            color: #f5f5dc;
            padding: 10px;
            font-weight: bold;
            font-size: 15px;
            border: none;
            border-radius: 4px;
            width: 100%;
            cursor: pointer;
            display: block;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #222;
        }

        .message {
            background-color: #003300;
            color: #80ff80;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .text-center {
            text-align: center;
        }

        a {
            color: #ccc;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Register new account</h2>

        <?php if (!empty($message)): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <input type="text" name="fullname" placeholder="Full Name" required>
            </div>

            <div class="form-group">
                <input type="text" name="address" placeholder="Address" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Email (must be @gmail.com)" required 
                       pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$"
                       title="Email must be a valid @gmail.com address">
            </div>

            <div class="form-group">
                <input type="text" name="contact" placeholder="Phone Number (11 digits)" required 
                       pattern="^[0-9]{11}$" 
                       title="Phone number must be exactly 11 digits">
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="form-group">
                <input type="password" name="confirm_password" placeholder="Re-enter Password" required>
            </div>

            <button type="submit" class="btn-submit">Create Account</button>
        </form>

        <p class="text-center mt-3">
            Already have an account? <a href="login.php">Login</a>
        </p>
    </div>
</body>
</html>
