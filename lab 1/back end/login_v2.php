<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>

<div class="login-page">
    <div class="text-center">
       <h1>Admin Panel</h1>
       <p>INVENTORY</p>
    </div>
    <?php echo display_msg($msg); ?>
    <form method="post" action="auth_v2.php" class="clearfix">
        <div class="form-group">
            <label for="username" class="control-label">Username</label>
            <input type="name" class="form-control" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password">
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-info mx-2">Login</button>
            <a href="http://localhost/customer/login.php" class="btn btn-info mx-2">Back</a>
        </div>
    </form>
</div>

<?php include_once('layouts/header.php'); ?>
