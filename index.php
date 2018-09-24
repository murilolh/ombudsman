<?php require_once 'config/config.php';
			require_once 'config/debug.php';
			require_once DBAPI;
			$msg = require 'const/strings.php'; ?>

<?php include(HEADER_TEMPLATE); ?>
<?php $db = open_database(); ?>

<hr />

<?php if ($db) : ?>

<div class="row">
	<div class="col-xs-6 col-sm-4 col-md-2">
		<a href="ticket/addticket.php" class="btn btn-primary">
			<div class="row">
				<div class="col-xs-12 text-center">
					<i class="fa fa-plus fa-5x"></i>
				</div>
				<div class="col-xs-12 text-center">
					<p><?php echo $msg['new'] . ' ' . $msg['ticket']; ?></p>
				</div>
			</div>
		</a>
	</div>

	<div class="col-xs-6 col-sm-4 col-md-2">
		<a href="ticket" class="btn btn-default">
			<div class="row">
				<div class="col-xs-12 text-center">
					<i class="fa fa-list fa-5x"></i>
				</div>
				<div class="col-xs-12 text-center">
					<p><?php echo $msg['tickets']; ?></p>
				</div>
			</div>
		</a>
	</div>

	<div class="col-xs-6 col-sm-4 col-md-2">
		<a href="ticket/report.php" class="btn btn-default">
			<div class="row">
				<div class="col-xs-12 text-center">
					<i class="fa fa-file-pdf-o fa-5x"></i>
				</div>
				<div class="col-xs-12 text-center">
					<p><?php echo $msg['report']; ?></p>
				</div>
			</div>
		</a>
	</div>

	<div class="col-xs-6 col-sm-4 col-md-2">
		<a href="ticket/charts.php" class="btn btn-default">
			<div class="row">
				<div class="col-xs-12 text-center">
					<i class="fa fa-bar-chart-o fa-5x"></i>
				</div>
				<div class="col-xs-12 text-center">
					<p><?php echo $msg['charts']; ?></p>
				</div>
			</div>
		</a>
	</div>

	<div class="col-xs-6 col-sm-4 col-md-2">
		<a href="ticket/export.php" class="btn btn-default">
			<div class="row">
				<div class="col-xs-12 text-center">
					<i class="fa fa-upload fa-5x"></i>
				</div>
				<div class="col-xs-12 text-center">
					<p><?php echo $msg['export']; ?></p>
				</div>
			</div>
		</a>
	</div>

<?php else : ?>
	<div class="alert alert-danger" role="alert">
		<p><strong><?php echo $msg['err']; ?>:</strong> <?php echo $msg['err_db']; ?></p>
	</div>

<?php endif; ?>

<?php include(FOOTER_TEMPLATE); ?>
