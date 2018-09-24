<?php
  require_once('../config/debug.php');
  require_once('functionsticket.php');
  add();
  sendTicketEmail('created');
  $msg = require '../const/strings.php';
?>

<?php include(HEADER_TEMPLATE); ?>

<h2><?php echo $msg['new'] . ' ' . $msg['ticket']; ?></h2>

<form action="addticket.php" data-toggle="validator" method="post">
  <?php include('formticket.php'); ?>

  <div id="actions" class="row">
    <div class="col-md-12">
      <button type="submit" class="btn btn-primary"><?php echo $msg['save']; ?></button>
      <a href="index.php" class="btn btn-default"><?php echo $msg['cancel']; ?></a>
    </div>
  </div>
</form>

<?php include(FOOTER_TEMPLATE); ?>
