<?php
  $page_title = 'Daily Sales';
  require_once('includes/load.php');
  page_require_level(3);
?>

<?php
 $year  = date('Y');
 $month = date('m');
 $sales = dailySales($year,$month);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default shadow-sm">
      <div class="panel-heading clearfix bg-light border-bottom py-2 px-3">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Daily Sales</span>
        </strong>
      </div>
      <div class="panel-body table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead class="table-dark text-center">
            <tr>
              <th style="width: 50px;">#</th>
              <th>Product name</th>
              <th style="width: 15%;">Quantity sold</th>
              <th style="width: 15%;">Total</th>
              <th style="width: 15%;">Date</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sales as $sale):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td><?php echo remove_junk($sale['name']); ?></td>
                <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
                <td class="text-center"><?php echo remove_junk($sale['total_saleing_price']); ?></td>
                <td class="text-center"><?php echo $sale['date']; ?></td>
              </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
