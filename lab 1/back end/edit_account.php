<?php
  $page_title = 'Edit Account';
  require_once('includes/load.php');
  page_require_level(3);
?>
<?php

  if(isset($_POST['submit'])) {
    $photo = new Media();
    $user_id = (int)$_POST['user_id'];
    $photo->upload($_FILES['file_upload']);
    if($photo->process_user($user_id)){
      $session->msg('s','photo has been uploaded.');
      redirect('edit_account.php');
    } else {
      $session->msg('d', join($photo->errors));
      redirect('edit_account.php');
    }
  }
?>
<?php

  if(isset($_POST['update'])){
    $req_fields = array('name','username' );
    validate_fields($req_fields);
    if(empty($errors)){
      $id = (int)$_SESSION['user_id'];
      $name = remove_junk($db->escape($_POST['name']));
      $username = remove_junk($db->escape($_POST['username']));
      $sql = "UPDATE users SET name ='{$name}', username ='{$username}' WHERE id='{$id}'";
      $result = $db->query($sql);
      if($result && $db->affected_rows() === 1){
        $session->msg('s',"Account updated ");
        redirect('edit_account.php', false);
      } else {
        $session->msg('d',' Sorry failed to update!');
        redirect('edit_account.php', false);
      }
    } else {
      $session->msg("d", $errors);
      redirect('edit_account.php',false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-6 mb-4">
    <div class="panel panel-default shadow-sm">
      <div class="panel-heading bg-light py-2 px-3">
        <div class="clearfix">
          <span class="glyphicon glyphicon-camera"></span>
          <span>Change My photo</span>
        </div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-4 text-center mb-3">
            <img class="img-thumbnail rounded-circle" style="width: 100px; height: 100px;" src="uploads/users/<?php echo $user['image'];?>" alt="">
          </div>
          <div class="col-md-8">
            <form class="form" action="edit_account.php" method="POST" enctype="multipart/form-data">
              <div class="form-group mb-3">
                <input type="file" name="file_upload" multiple="multiple" class="form-control"/>
              </div>
              <div class="form-group">
                <input type="hidden" name="user_id" value="<?php echo $user['id'];?>">
                <button type="submit" name="submit" class="btn btn-warning w-100">Change</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 mb-4">
    <div class="panel panel-default shadow-sm">
      <div class="panel-heading bg-light py-2 px-3 clearfix">
        <span class="glyphicon glyphicon-edit"></span>
        <span>Edit My Account</span>
      </div>
      <div class="panel-body">
        <form method="post" action="edit_account.php?id=<?php echo (int)$user['id'];?>" class="clearfix">
          <div class="form-group mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="name" class="form-control" name="name" value="<?php echo remove_junk(ucwords($user['name'])); ?>">
          </div>
          <div class="form-group mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo remove_junk(ucwords($user['username'])); ?>">
          </div>
          <div class="form-group clearfix d-flex justify-content-between">
            <a href="change_password.php" title="change password" class="btn btn-danger">Change Password</a>
            <button type="submit" name="update" class="btn btn-info">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
