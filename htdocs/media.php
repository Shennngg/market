<?php
  $page_title = 'All Image';
  require_once('includes/load.php');
  page_require_level(2);
?>
<?php $media_files = find_all('media'); ?>
<?php
  if(isset($_POST['submit'])) {
    $photo = new Media();
    $photo->upload($_FILES['file_upload']);
    if($photo->process_media()){
        $session->msg('s','photo has been uploaded.');
        redirect('media.php');
    } else{
      $session->msg('d',join($photo->errors));
      redirect('media.php');
    }
  }
?>
<?php include_once('layouts/header.php'); ?>

<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<div class="container-fluid">
  <div class="row mb-3">
    <div class="col-md-6">
      <?php echo display_msg($msg); ?>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div>
            <i class="bi bi-camera"></i>
            <strong>All Photos</strong>
          </div>
          <form class="d-flex flex-wrap gap-2" action="media.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file_upload" multiple="multiple" class="form-control" />
            <button type="submit" name="submit" class="btn btn-primary">Upload</button>
          </form>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
              <tr>
                <th style="width: 50px;">#</th>
                <th>Photo</th>
                <th>Photo Name</th>
                <th style="width: 20%;">Photo Type</th>
                <th style="width: 50px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($media_files as $media_file): ?>
              <tr>
                <td><?php echo count_id();?></td>
                <td>
                  <img src="uploads/products/<?php echo $media_file['file_name'];?>" class="img-thumbnail" style="max-width: 100px;" />
                </td>
                <td><?php echo $media_file['file_name'];?></td>
                <td><?php echo $media_file['file_type'];?></td>
                <td>
                  <a href="delete_media.php?id=<?php echo (int) $media_file['id'];?>" class="btn btn-danger btn-sm" title="Delete">
                    <i class="bi bi-trash"></i>
                  </a>
                </td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
