<?php
  $page_title = 'Edit categorie';
  require_once('includes/load.php');
  page_require_level(1);
?>
<?php
  $categorie = find_by_id('categories',(int)$_GET['id']);
  if(!$categorie){
    $session->msg("d","Missing categorie id.");
    redirect('categorie.php');
  }
?>

<?php
if(isset($_POST['edit_cat'])){
  $req_field = array('categorie-name');
  validate_fields($req_field);
  $cat_name = remove_junk($db->escape($_POST['categorie-name']));
  if(empty($errors)){
    $sql = "UPDATE categories SET name='{$cat_name}'";
    $sql .= " WHERE id='{$categorie['id']}'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1) {
      $session->msg("s", "Successfully updated Categorie");
      redirect('categorie.php',false);
    } else {
      $session->msg("d", "Sorry! Failed to Update");
      redirect('categorie.php',false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('categorie.php',false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-5 col-sm-12 mb-4">
    <div class="panel panel-default shadow-sm">
      <div class="panel-heading bg-light py-2 px-3">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Editing <?php echo remove_junk(ucfirst($categorie['name']));?></span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="edit_categorie.php?id=<?php echo (int)$categorie['id'];?>">
          <div class="form-group mb-3">
            <input type="text" class="form-control" name="categorie-name" value="<?php echo remove_junk(ucfirst($categorie['name']));?>">
          </div>
          <button type="submit" name="edit_cat" class="btn btn-primary w-100">Update categorie</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
