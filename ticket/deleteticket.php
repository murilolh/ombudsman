<?php
  require_once('../config/debug.php');
  require_once('functionsticket.php');
  $msg = require '../const/strings.php';
  if (isset($_GET['id'])){
    delete($_GET['id']);
  } else {
    die(echo $msg['id_not_defined'];);
  }
?>
