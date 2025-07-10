<?php include_once('includes/load.php'); ?>
<?php
$req_fields = array('username','password' );
validate_fields($req_fields);
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

  if(empty($errors)){

    $user = authenticate_v2($username, $password);

        if($user):
          
           $session->login($user['id']);
           
           updateLastLogIn($user['id']);
           
           if($user['user_level'] === '1'):
             $session->msg("s", "Hello ".$user['username'].", Welcome to Inventory & Sales.");
             redirect('admin.php',false);
           elseif ($user['user_level'] === '2'):
              $session->msg("s", "Hello ".$user['username'].", Welcome to Inventory.");
             redirect('home.php',false);
           else:
              $session->msg("s", "Hello ".$user['username'].", Welcome to Sales.");
             redirect('home.php',false);
           endif;

        else:
          $session->msg("d", "Sorry Username/Password incorrect.");
          redirect('login_v2.php',false);
        endif;

  } else {

     $session->msg("d", $errors);
     redirect('login_v2.php',false);
  }

?>
