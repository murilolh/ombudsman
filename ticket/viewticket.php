<?php
	require_once('../config/debug.php');
	require_once('functionsticket.php');
	$msg = require '../const/strings.php';
	init();
	view($_GET['id']);
?>

<?php include(HEADER_TEMPLATE); ?>

<h2><?php echo $msg['ticket']; ?> <?php echo $ticket['protocol']; ?></h2>
<hr>

<?php if (!empty($_SESSION['message'])) : ?>
	<div class="alert alert-<?php echo $_SESSION['type']; ?>"><?php echo $_SESSION['message']; ?></div>
<?php endif; ?>

<dl class="dl-horizontal">
	<dt style="width:20%;"><?php echo $msg['protocol']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['protocol']; ?></dd>

	<dt style="width:20%;"><?php echo $msg['ticket_type']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['id_ticket_type'] > 0 ? $ticket_types[$ticket['id_ticket_type']-1]['name'] : ""; ?></dd>

	<dt style="width:20%;"><?php echo $msg['channel']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['id_channel'] > 0 ? $channels[$ticket['id_channel']-1]['name'] : ""; ?></dd>

	<dt style="width:20%;"><?php echo $msg['theme']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['id_ticket_theme'] > 0 ? $themes[$ticket['id_ticket_theme']-1]['name'] : ""; ?></dd>

	<dt style="width:20%;"><?php echo $msg['object_theme']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['theme_object']; ?></dd>

	<dt style="width:20%;"><?php echo $msg['complaint_theme']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['id_complaint_theme'] > 0 ? $themes[$ticket['id_complaint_theme']-1]['name'] : ""; ?></dd>

	<dt style="width:20%;"><?php echo $msg['contract_type']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['id_contract_type'] > 0 ? $contract_types[$ticket['id_contract_type']-1]['name'] : ""; ?></dd>

	<dt style="width:20%;"><?php echo $msg['created']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo !empty($ticket['ticket_date_ini']) ? date_format(date_create($ticket['ticket_date_ini']),DATEFORMAT) : null; ?></dd>

	<dt style="width:20%;"><?php echo $msg['finalized']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo !empty($ticket['ticket_date_fin']) ? date_format(date_create($ticket['ticket_date_fin']),DATEFORMAT) : null; ?></dd>

	<dt style="width:20%;"><?php echo $msg['deadline_days']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['deadline_days']; ?></dd>

	<dt style="width:20%;"><?php echo $msg['limit_date']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo !empty($ticket['deadline_date']) ? date_format(date_create($ticket['deadline_date']),DATEFORMAT) : null; ?></dd>

	<dt style="width:20%;"><?php echo $msg['deadline_type']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['id_deadline_type'] > 0 ? $deadline_types[$ticket['id_deadline_type']-1]['name'] : ""; ?></dd>

	<dt style="width:20%;"><?php echo $msg['deadline_conclusion']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['id_deadline_conclusion'] > 0 ? $deadline_conclusions[$ticket['id_deadline_conclusion']-1]['name'] : ""; ?></dd>

	<dt style="width:20%;"><?php echo $msg['person_type']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['id_person_type'] > 0 ? $person_types[$ticket['id_person_type']-1]['name'] : ""; ?></dd>

	<dt style="width:20%;"><?php echo $msg['person_name']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['person_name']; ?></dd>

	<dt style="width:20%;"><?php echo $msg['person_phone']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['person_phone']; ?></dd>

	<dt style="width:20%;"><?php echo $msg['person_email']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['person_email']; ?></dd>

	<dt style="width:20%;"><?php echo $msg['reanalysis_req']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['reanalysis'] == '1' ? "Sim" : "Não"; ?></dd>

	<dt style="width:20%;"><?php echo $msg['emails_notify']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['emails']; ?></dd>

	<dt style="width:20%;"><?php echo $msg['obs']; ?>:</dt>
	<dd style="margin-left: 250px;"><?php echo $ticket['obs_text']; ?></dd>
</dl>

<div id="actions" class="row">
	<div class="col-md-12">
	  <a href="editticket.php?id=<?php echo $ticket['id']; ?>" class="btn btn-primary"><?php echo $msg['edit']; ?></a>
	  <a href="index.php" class="btn btn-default"><?php echo $msg['back']; ?></a>
	</div>
</div>

<?php include(FOOTER_TEMPLATE); ?>
