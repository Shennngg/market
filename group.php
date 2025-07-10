<?php
  $page_title = 'All Group';
  require_once('includes/load.php');
  page_require_level(1);
  $all_groups = find_all('user_groups');
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
   <div class="col-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix d-flex justify-content-between align-items-center">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Groups</span>
        </strong>
        <a href="add_group.php" class="btn btn-info btn-sm"> Add New Group</a>
      </div>
      <div class="panel-body table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
          <thead class="table-light">
            <tr>
              <th style="width: 50px;">#</th>
              <th class="text-start">Group Name</th>
              <th style="width: 20%;">Group Level</th>
              <th style="width: 15%;">Status</th>
              <th style="width: 100px;">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($all_groups as $a_group): ?>
            <tr>
              <td><?php echo count_id();?></td>
              <td class="text-start"><?php echo remove_junk(ucwords($a_group['group_name']))?></td>
              <td><?php echo remove_junk(ucwords($a_group['group_level']))?></td>
              <td>
                <?php if($a_group['group_status'] === '1'): ?>
                  <span class="badge bg-success"><?php echo "Active"; ?></span>
                <?php else: ?>
                  <span class="badge bg-danger"><?php echo "Deactive"; ?></span>
                <?php endif;?>
              </td>
              <td>
                <div class="btn-group">
                  <a href="edit_group.php?id=<?php echo (int)$a_group['id'];?>" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                    <i class="glyphicon glyphicon-pencil"></i>
                  </a>
                  <a href="delete_group.php?id=<?php echo (int)$a_group['id'];?>" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Remove">
                    <i class="glyphicon glyphicon-remove"></i>
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
