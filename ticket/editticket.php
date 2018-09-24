<?php
  require_once('../config/debug.php');
  require_once('functionsticket.php');
  edit();
  sendTicketEmail('updated');
  $msg = require '../const/strings.php';
?>

<?php include(HEADER_TEMPLATE); ?>

<h2><?php echo $msg['update'] . ' ' . $msg['ticket']; ?></h2>

<form action="editticket.php?id=<?php echo $ticket['id']; ?>" data-toggle="validator" method="post">
  <?php include('formticket.php'); ?>

  <div id="actions" class="row">
    <div class="col-md-12">
      <p><i><?php echo $msg['last_notify']; ?> <?php echo date_format(date_create($ticket['modified']), DATEFORMAT); ?></i></p>
      <button type="submit" class="btn btn-primary"><?php echo $msg['save']; ?></button>
      <a href="index.php" class="btn btn-default"><?php echo $msg['cancel']; ?></a>
      <button id="btnNotify" type="button" href="#" class="btn btn-default" data-toggle="modal" data-target="#notify-modal" data-ticket="<?php echo $ticket['id']; ?>"
         data-protocol="<?php echo $ticket['protocol']; ?>" <?php echo empty($ticket['emails']) ? 'style="visibility:hidden"': ''; ?> ><?php echo $msg['notify_emails']; ?></button>
    </div>
  </div>
</form>

<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>
