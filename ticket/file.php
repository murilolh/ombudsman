<?php
  require_once('../config/debug.php');
  require_once('functionsticket.php');
  $msg = require '../const/strings.php';
  getYears();
  if (!empty($_POST['filter'])) {
    $filter = $_POST['filter'];
    $filter['year'] = $filter["'year'" ];

    init();
    getTicketsByYear($filter['year']);

    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename='.SYSTEMNAME . $filter['year'] . '.csv');

  } else {
    $filter['year'] = '';
  }
?>
<?php echo $msg['protocol'].';'.
           $msg['ticket_type'].';'.
           $msg['channel'].';'.
           $msg['theme'].';'.
           $msg['object_theme'].';'.
           $msg['complaint_theme'].';'.
           $msg['contract_type'].';'.
           $msg['created'].';'.
           $msg['finalized'].';'.
           $msg['business_days'].';'.
           $msg['limit_date'].';'.
           $msg['deadline_type'].';'.
           $msg['deadline_conclusion'].';'.
           $msg['person_type'].';'.
           $msg['person_name'].';'.
           $msg['person_phone'].';'.
           $msg['person_email'].';'.
           $msg['reanalysis_req'].';'.
           $msg['emails_notify'].';'.
           $msg['obs']; ?>
<?php
  $nl = "\n";
  echo $nl;
  foreach ($ticketsByYear as $ticket) :
    echo ($ticket['protocol']) . ';' .
         ($ticket['id_ticket_type'] > 0 ? $ticket_types[$ticket['id_ticket_type']-1]['name'] : "") . ';' .
         ($ticket['id_channel'] > 0 ? $channels[$ticket['id_channel']-1]['name'] : "") . ';' .
         ($ticket['id_ticket_theme'] > 0 ? $themes[$ticket['id_ticket_theme']-1]['name'] : "") . ';' .
         ($ticket['theme_object']) . ';' .
         ($ticket['id_complaint_theme'] > 0 ? $themes[$ticket['id_complaint_theme']-1]['name'] : "") . ';' .
         ($ticket['id_contract_type'] > 0 ? $contract_types[$ticket['id_contract_type']-1]['name'] : "") . ';' .
         (!empty($ticket['ticket_date_ini']) ? date_format(date_create($ticket['ticket_date_ini']), DATEFORMAT) : "") . ';' .
         (!empty($ticket['ticket_date_fin']) ? date_format(date_create($ticket['ticket_date_fin']), DATEFORMAT) : "") . ';' .
         ($ticket['deadline_days']) . ';' .
         (!empty($ticket['deadline_date']) ? date_format(date_create($ticket['deadline_date']), DATEFORMAT) : "") . ';' .
         ($ticket['id_deadline_type'] > 0 ? $deadline_types[$ticket['id_deadline_type']-1]['name'] : "") . ';' .
         ($ticket['id_deadline_conclusion'] > 0 ? $deadline_conclusions[$ticket['id_deadline_conclusion']-1]['name'] : "") . ';' .
         ($ticket['id_person_type'] > 0 ? $person_types[$ticket['id_person_type']-1]['name'] : "") . ';' .
         ($ticket['person_name']) . ';' .
         ($ticket['person_phone']) . ';' .
         ($ticket['person_email']) . ';' .
         ($ticket['reanalysis'] == '1' ? "Sim" : "Não") . ';' .
         ($ticket['emails']) . ';' .
         (str_replace(array("\r\n", "\n", "\r") , ' ', str_replace(';',':',$ticket['obs_text']))) ;
    echo $nl;
  endforeach;

  ?>
