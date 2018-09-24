<?php
  require_once('../config/debug.php');
  require_once('functionsticket.php');
  $msg = require '../const/strings.php';
  getYears();
  if (!empty($_POST['filter'])) {
    $filter = $_POST['filter'];
    $filter['year'] = $filter["'year'" ];
  } else {
    $filter['year'] = '';
  }
?>

<?php include(HEADER_TEMPLATE); ?>

<header>
	<div class="row">
		<div class="col-sm-6">
			<h2><?php echo $msg['export']; ?></h2>
		</div>
	</div>
</header>

<?php if (!empty($_SESSION['message'])) : ?>
	<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $_SESSION['message']; ?>
	</div>
	<?php clear_messages(); ?>
<?php endif; ?>

<hr>
<form action="file.php" data-toggle="validator" method="post" target="_blank">

  <div>
    <div class="row">
      <div class="form-group col-md-offset-5 col-md-2 text-center">
        <label for="formReportYear"><?php echo $msg['year_msg']; ?>*</label>
        <select id="formTicketType" class="form-control text-center" required="true" name="filter['year']">
          <option value=""><?php echo $msg['select_option']; ?></option>
          <?php foreach ($years as $year) : ?>
          <?php   echo "<option value=\"{$year['ano']}\""; ?>
          <?php   echo ">{$year['ano']}</option>"; ?>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div id="actions" class="row">
      <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary"><?php echo $msg['export']; ?></button>
      </div>
    </div>
  </div>

</form>

<?php include(FOOTER_TEMPLATE); ?>
