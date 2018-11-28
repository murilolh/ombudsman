<?php
  require_once('../config/debug.php');
  require_once('functionsticket.php');
  require_once('paginator.php');
  $msg = require '../const/strings.php';

  init();

  if (!empty($_POST['filter'])) {
    $filter = $_POST['filter'];
    $filter['visible'] = $filter["'protocol'" ] || $filter["'id_ticket_type'" ] || $filter["'id_channel'" ] ||
                         $filter["'id_ticket_theme'" ] || $filter["'ticket_date_ini'" ] || $filter["'ticket_date_fin'" ] || $filter["'id_deadline_conclusion'" ] ||
                         $filter["'ticket_date_estab_ini'" ] || $filter["'ticket_date_estab_fin'" ] || $filter["'deadline_days'" ] ||
                         (!empty($filter["'showPending'"]) && $filter["'showPending'" ] == 1);
    $filter['protocol'] = $filter["'protocol'" ];
    $filter['id_ticket_type'] = $filter["'id_ticket_type'" ];
    $filter['id_channel'] = $filter["'id_channel'" ];
    $filter['id_ticket_theme'] = $filter["'id_ticket_theme'" ];
    $filter['ticket_date_ini'] = $filter["'ticket_date_ini'" ];
    $filter['ticket_date_fin'] = $filter["'ticket_date_fin'" ];
    $filter['id_deadline_conclusion'] = $filter["'id_deadline_conclusion'" ];
    $filter['ticket_date_estab_ini'] = $filter["'ticket_date_estab_ini'" ];
    $filter['ticket_date_estab_fin'] = $filter["'ticket_date_estab_fin'" ];
    $filter['deadline_days'] = $filter["'deadline_days'" ];
    if(!empty($filter["'showPending'"])){
      $filter['showPending'] = $filter["'showPending'" ];
    } else {
      $filter['showPending'] = 0;
    }
    $filter['page'] = $filter["'page'" ];
  } else {
    $filter['visible'] = false;
    $filter['protocol'] = '';
    $filter['id_ticket_type'] = '';
    $filter['id_channel'] = '';
    $filter['id_ticket_theme'] = '';
    $filter['ticket_date_ini'] = '';
    $filter['ticket_date_fin'] = '';
    $filter['id_deadline_conclusion'] = '';
    $filter['ticket_date_estab_ini'] = '';
    $filter['ticket_date_estab_fin'] = '';
    $filter['deadline_days'] = '';
    $filter['showPending'] = 0;
    $filter['page'] = 1;
  }

  $conn = get_connection();
  $limit = PAGINATOR_LIMIT;
  $links = PAGINATOR_LINKS;
  $paginator = new Paginator( $conn, getQuery() );
  $results = $paginator->getData( $limit, $filter['page'] );
  close_connection($conn);

?>

<?php include(HEADER_TEMPLATE); ?>

<header>
	<div class="row">
		<div class="col-sm-6">
			<h2><?php echo $msg['tickets']; ?></h2>
		</div>
		<div class="col-sm-6 text-right h2">
	    	<a class="btn btn-primary" href="addticket.php"><i class="fa fa-plus"></i> <?php echo $msg['new'] . ' ' . $msg['ticket']; ?></a>
	    	<a class="btn btn-default" href="index.php"><i class="fa fa-refresh"></i> <?php echo $msg['refresh']; ?></a>
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
<form id="formTicket" action="index.php" data-toggle="validator" method="post">

  <div class="row">
    <div class="col-md-2">
      <button type="button" data-toggle="collapse" data-target="#filter" class="btn btn-primary"><?php echo $msg['filters']; ?></button>
    </div>
    <div class="col-md-2">
      <input id="formFilterVisible" type="boolean" style="display : none" class="form-control" name="filter['visible']" value="<?php echo $filter['visible']; ?>">
    </div>
    <div class="col-md-2">
      <input id="formFilterPage" type="text" style="display : none" class="form-control" name="filter['page']" value="<?php echo $filter['page']; ?>">
    </div>
  </div>
  <br>
  <div id="filter" class="collapse <?php echo $filter['visible'] ? "in" : ""; ?>">
    <div class="row">
      <div class="form-group col-md-3">
        <label for="formProtocol"><?php echo $msg['protocol']; ?></label>
        <input id="formProtocol" type="text" data-mask="0000000000000000000" class="form-control" name="filter['protocol']" value="<?php echo $filter['protocol']; ?>">
      </div>
      <div class="form-group col-md-3">
        <label for="formTicketType"><?php echo $msg['ticket_type']; ?></label>
        <select id="formTicketType" class="form-control" name="filter['id_ticket_type']">
          <option value="" <?php if ($filter['id_ticket_type'] == '') { echo "selected"; } ?>><?php echo $msg['select_option']; ?></option>
          <?php foreach ($ticket_types as $ticket_type) : ?>
          <?php   echo "<option value=\"{$ticket_type['id']}\""; ?>
          <?php   echo $filter['id_ticket_type'] == $ticket_type['id'] ? "selected" : ""; ?>
          <?php   echo ">{$ticket_type['name']}</option>"; ?>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="formChannel"><?php echo $msg['channel']; ?></label>
        <select id="formChannel" class="form-control" name="filter['id_channel']">
          <option value="" <?php if ($filter['id_channel'] == '') { echo "selected"; } ?>><?php echo $msg['select_option']; ?></option>
          <?php foreach ($channels as $channel) : ?>
          <?php   echo "<option value=\"{$channel['id']}\""; ?>
          <?php   echo $filter['id_channel'] == $channel['id'] ? "selected" : ""; ?>
          <?php   echo ">{$channel['name']}</option>"; ?>
          <?php endforeach; ?>
        </select>
      </div>
    	<div class="form-group col-md-3">
        <label for="formTicketTheme"><?php echo $msg['theme']; ?></label>
        <select id="formTicketTheme" class="form-control" name="filter['id_ticket_theme']">
          <option value="" <?php if ($filter['id_ticket_theme'] == '') { echo "selected"; } ?>><?php echo $msg['select_option']; ?></option>
          <?php foreach ($themes as $theme) : ?>
          <?php   echo "<option value=\"{$theme['id']}\""; ?>
          <?php   echo $filter['id_ticket_theme'] == $theme['id'] ? "selected" : ""; ?>
          <?php   echo ">{$theme['name']}</option>"; ?>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-3">
        <label for="formDataIni"><?php echo $msg['create_str']; ?></label>
        <input id="formDataIni" type="date" min="2000-01-01" max="2099-12-31" class="form-control" name="filter['ticket_date_ini']" value="<?php echo $filter['ticket_date_ini']; ?>">
    		<div class="help-block with-errors"></div>
      </div>
      <div class="form-group col-md-3">
        <label for="formDataFin"><?php echo $msg['create_end']; ?></label>
        <input id="formDataFin" type="date" min="2000-01-01" max="2099-12-31" class="form-control" name="filter['ticket_date_fin']" value="<?php echo $filter['ticket_date_fin']; ?>">
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group col-md-6">
        <label for="formDeadlineConc"><?php echo $msg['deadline_conclusion']; ?></label>
        <select id="formDeadlineConc" class="form-control" name="filter['id_deadline_conclusion']">
          <option value="" <?php if ($filter['id_deadline_conclusion'] == '') { echo "selected"; } ?>><?php echo $msg['select_option']; ?></option>
          <?php foreach ($deadline_conclusions as $deadline_conclusion) : ?>
          <?php   echo "<option value=\"{$deadline_conclusion['id']}\""; ?>
          <?php   echo $filter['id_deadline_conclusion'] == $deadline_conclusion['id'] ? "selected" : ""; ?>
          <?php   echo ">{$deadline_conclusion['name']}</option>"; ?>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-3">
        <label for="formDataEstabIni"><?php echo $msg['limit_date_str']; ?></label>
        <input id="formDataEstabIni" type="date" min="2000-01-01" max="2099-12-31" class="form-control" name="filter['ticket_date_estab_ini']" value="<?php echo $filter['ticket_date_estab_ini']; ?>">
    		<div class="help-block with-errors"></div>
      </div>
      <div class="form-group col-md-3">
        <label for="formDataEstabFin"><?php echo $msg['limit_date_end']; ?></label>
        <input id="formDataEstabFin" type="date" min="2000-01-01" max="2099-12-31" class="form-control" name="filter['ticket_date_estab_fin']" value="<?php echo $filter['ticket_date_estab_fin']; ?>">
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group col-md-3">
        <label for="formProtocol"><?php echo $msg['deadline_days']; ?></label>
        <input id="formDeadlineDays" type="text" data-mask="000" class="form-control" name="filter['deadline_days']" value="<?php echo $filter['deadline_days']; ?>">
      </div>
    	<div class="form-group col-md-3">
        <label for="formShowPending">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <label><input id="formShowPending" type="checkbox" name="filter['showPending']" <?php if ($filter['showPending'] == '1') { echo "checked"; } ?> value="1">&nbsp;<?php echo $msg['show_pending_only']; ?></label>
      </div>
    </div>

    <div id="actions" class="row">
      <div class="col-md-12 text-center">
        <button type="submit" onclick="changePage(1);" class="btn btn-primary"><?php echo $msg['filter']; ?></button>
      </div>
    </div>
  </div>

  <hr>

  <table class="table table-striped table-hover">
    <thead>
    	<tr>
        <th></th>
    		<th><?php echo $msg['protocol']; ?></th>
        <th><?php echo $msg['type']; ?></th>
        <th><?php echo $msg['channel']; ?></th>
        <th><?php echo $msg['theme']; ?></th>
        <th><?php echo $msg['created']; ?></th>
        <th><?php echo $msg['finalized']; ?></th>
        <th><?php echo $msg['limit_date']; ?></th>
    		<th></th>
    	</tr>
    </thead>
    <tbody>
      <?php
        if ($results->data) :
          for ($p = 0; $p < count($results->data); $p++):
            $ticket = $results->data[$p] ?>
            <tr>
              <td><?php
                   if(!empty($ticket['ticket_date_fin'])){
                     echo '<a href="#" class="btn btn-sm btn-info"><i class="fa"></i> &nbsp;&nbsp; </a>';
                   } else if(!empty($ticket['deadline_date'])) {
                     $deadline = date_create($ticket['deadline_date']);
                     $today = date_create('now', new DateTimeZone(TIMEZONE));
                     $tomorrow = date_create('now', new DateTimeZone(TIMEZONE));
                     $tomorrow->modify('+1 Weekday');

                     if(date_format($deadline,DATEFORMAT) == date_format($tomorrow,DATEFORMAT)){
                       echo '<a href="#" class="btn btn-sm btn-warning"><i class="fa"></i> &nbsp;&nbsp; </a>';
                     } else if($deadline > $today){
                       echo '<a href="#" class="btn btn-sm btn-success"><i class="fa"></i> &nbsp;&nbsp; </a>';
                     } else {
                       echo '<a href="#" class="btn btn-sm btn-danger"><i class="fa"></i> &nbsp;&nbsp; </a>';
                     }
                   } else {
                     echo "";
                   }
              ?></td>
          		<td><?php echo $ticket['protocol']; ?></td>
              <td><?php echo $ticket['id_ticket_type'] > 0 ? $ticket_types[$ticket['id_ticket_type']-1]['name'] : ""; ?></td>
              <td><?php echo $ticket['id_channel'] > 0 ? $channels[$ticket['id_channel']-1]['name'] : ""; ?></td>
              <td><?php echo $ticket['id_ticket_theme'] > 0 ? $themes[$ticket['id_ticket_theme']-1]['name'] : ""; ?></td>
              <td><?php echo date_format(date_create($ticket['ticket_date_ini']),DATEFORMAT); ?></td>
              <td><?php echo !empty($ticket['ticket_date_fin']) ? date_format(date_create($ticket['ticket_date_fin']),DATEFORMAT) : null; ?></td>
              <td><?php echo !empty($ticket['deadline_date']) ? date_format(date_create($ticket['deadline_date']),DATEFORMAT) : null; ?></td>
          		<td class="actions text-right">
          			<a href="viewticket.php?id=<?php echo $ticket['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
          			<a href="editticket.php?id=<?php echo $ticket['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
          			<a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal" data-ticket="<?php echo $ticket['id']; ?>" data-protocol="<?php echo $ticket['protocol']; ?>">
          				<i class="fa fa-trash"></i></a>
                <?php if (!empty($ticket['emails'])) : ?>
                  <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#notify-modal" data-ticket="<?php echo $ticket['id']; ?>" data-protocol="<?php echo $ticket['protocol']; ?>">
                    <i class="fa fa-bell"></i></a>
              	<?php endif; ?>
          		</td>
          	</tr>
          <?php endfor; ?>
        <?php else : ?>
        	<tr>
        		<td colspan="6"><?php echo $msg['not_found']; ?></td>
        	</tr>
      <?php endif; ?>
    </tbody>
  </table>

  <?php if ($results->data) : ?>
    <div class="row">
      <div class="col-md-12 text-center">
        <?php echo $paginator->createLinks( $links, 'pagination pagination-sm' ); ?>
      </div>
    </div>
  <?php endif; ?>

</form>

<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>
