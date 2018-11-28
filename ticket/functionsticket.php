<?php

require_once('../config/config.php');
require_once(DBAPI);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../mail/Exception.php';
require '../mail/PHPMailer.php';
require '../mail/SMTP.php';

$ticket = null;
$channels = null;
$themes = null;
$ticket_types = null;
$person_types = null;
$deadline_types = null;
$deadline_conclusions = null;
$contract_types = null;
$years = null;
$ticketsByYear =  null;
$ticketsByReanalysis = null;
$ticketsByMonth = null;
$ticketsByChannel = null;
$ticketsByTheme = null;
$ticketsByObjectTheme = null;
$ticketsByType = null;
$ticketsComplaintByTheme = null;
$ticketsComplaintByContract = null;
$ticketsComplaintByPerson = null;
$ticketsByConclusion = null;
$daysToConclusion = null;
$qtdOK = null;
$qtdOKByConclusion = null;

$nextTicketId = null;

function get_connection() {
  return open_database();
}

function close_connection($conn) {
  return close_database($conn);
}

function getQuery() {
	$whereExpress = '';
	if (!empty($_POST['filter'])) {
		$filter = $_POST['filter'];

		if($filter["'protocol'"]){
			$whereExpress = $whereExpress . "and protocol like '%" . $filter["'protocol'"] . "%'";
		}
		if($filter["'id_ticket_type'"]){
			$whereExpress = $whereExpress . "and id_ticket_type = '" . $filter["'id_ticket_type'"] . "'";
		}
		if($filter["'id_channel'"]){
			$whereExpress = $whereExpress . "and id_channel = '" . $filter["'id_channel'"] . "'";
		}
		if($filter["'id_ticket_theme'"]){
			$whereExpress = $whereExpress . "and id_ticket_theme = '" . $filter["'id_ticket_theme'"] . "'";
		}
		if($filter["'ticket_date_ini'"]){
			$whereExpress = $whereExpress . "and ticket_date_ini >= '" . $filter["'ticket_date_ini'"] . "'";
		}
		if($filter["'ticket_date_fin'"]){
			$whereExpress = $whereExpress . "and ticket_date_ini <= '" . $filter["'ticket_date_fin'"] . "'";
		}
		if($filter["'id_deadline_conclusion'"]){
			$whereExpress = $whereExpress . "and id_deadline_conclusion = '" . $filter["'id_deadline_conclusion'"] . "'";
		}
    if($filter["'ticket_date_estab_ini'"]){
			$whereExpress = $whereExpress . "and deadline_date is not null and deadline_date >= '" . $filter["'ticket_date_estab_ini'"] . "'";
		}
		if($filter["'ticket_date_estab_fin'"]){
			$whereExpress = $whereExpress . "and deadline_date is not null and deadline_date <= '" . $filter["'ticket_date_estab_fin'"] . "'";
		}
    if($filter["'deadline_days'"]){
			$whereExpress = $whereExpress . "and ticket_date_fin is null and deadline_date is not null and deadline_date < DATE_ADD(CURDATE(), INTERVAL " . $filter["'deadline_days'"] . "  DAY)";
		}
    if(!empty($filter["'showPending'"]) && $filter["'showPending'"] == 1){
			$whereExpress = $whereExpress . "and ticket_date_fin is null";
		}
	}
	return "SELECT * FROM ticket WHERE 1 = 1 " . $whereExpress . " ORDER BY protocol desc";
}

function view($id = null) {
  global $ticket;
  $ticket = find('ticket', $id);
}

function findNextTicketId() {
  global $nextTicketId;
  $nextTicketId = findNextId('ticket');
}

function add() {
  global $ticket;
  if (!empty($_POST['ticket'])) {
    $ticket = $_POST['ticket'];

    $today = date_create('now', new DateTimeZone(TIMEZONE));
    $ticket['modified'] = $ticket['created'] = $today->format("Y-m-d H:i:s");

    $year = date_format(date_create_from_format('Y-m-d', $ticket["'ticket_date_ini'"]), "Y");

    $nextProtocol = queryUnique("SELECT MAX(SUBSTR(protocol, 5, 7))+1 max FROM ticket WHERE YEAR(ticket_date_ini) = '" . $year . "'");
    if(empty($nextProtocol['max'])){
      $nextProtocol['max'] = 1;
    }

    $nextProtocol['max'] = str_pad($nextProtocol['max'], 3, "0", STR_PAD_LEFT);
    $ticket["'protocol'"] = '' . $year . $nextProtocol['max'];

    save('ticket', $ticket);
    header('location: index.php');
  }
}

function edit() {
  global $ticket;
  if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_POST['ticket'])) {
      $ticket = $_POST['ticket'];
      if(empty($ticket["'reanalysis'"])){
        $ticket["'reanalysis'"] = 0;
      }

      $today = date_create('now', new DateTimeZone(TIMEZONE));
      $ticket['modified'] = $today->format("Y-m-d H:i:s");

      update('ticket', $id, $ticket);
      header('location: index.php');
    } else {
      global $ticket;
      $ticket = find('ticket', $id);
    }
  } else {
    header('location: index.php');
  }
}

function delete($id = null) {
  global $ticket;
  $ticket = remove('ticket', $id);
  header('location: index.php');
}

function getChannels() {
	global $channels;
	if(empty($channels)) {
		$channels = find_all('channel');
	}
}

function getThemes() {
	global $themes;
	if(empty($themes)) {
		$themes = find_all('theme');
	}
}

function getTicketTypes() {
	global $ticket_types;
	if(empty($ticket_types)) {
		$ticket_types = find_all('ticket_type');
	}
}

function getPersonTypes() {
	global $person_types;
	if(empty($person_types)) {
		$person_types = find_all('person_type');
	}
}

function getDeadlineTypes() {
	global $deadline_types;
	if(empty($deadline_types)) {
		$deadline_types = find_all('deadline_type');
	}
}

function getDeadlineConclusions() {
	global $deadline_conclusions;
	if(empty($deadline_conclusions)) {
		$deadline_conclusions = find_all('deadline_conclusion');
	}
}

function getContractTypes() {
	global $contract_types;
	if(empty($contract_types)) {
		$contract_types = find_all('contract_type');
	}
}

function init() {
	getChannels();
	getThemes();
	getTicketTypes();
	getPersonTypes();
	getDeadlineTypes();
	getDeadlineConclusions();
	getContractTypes();
}

function sendTicketEmail($operacao = null, $emails = null, $id = null) {
  global $ticket;
  global $channels;
	global $themes;
	global $ticket_types;
	global $person_types;
	global $deadline_types;
	global $deadline_conclusions;
	global $contract_types;
	init();

  $quote = "'";
  if($id){
    $quote = "";
    $ticket = find('ticket', $id);
  }

	if (!empty($_POST['ticket']) || $id) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      )
    );
    $mail->Mailer = "smtp";
    $mail->SMTPDebug = 0;
    $mail->Host = SMTP_HOST;
		$mail->Port = SMTP_PORT;
		$mail->SMTPSecure = 'ssh';
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USER;
		$mail->Password = SMTP_PASS;
		$mail->setFrom(SMTP_USER, SMTP_USERNAME);
    if($emails){
      $arrEmails = explode(',', $emails);
      foreach ($arrEmails as $email) {
        $mail->addAddress($email);
      }
    } else {
      $mail->addAddress(EMAIL_OMBUDSMAN);
    }
    $mail->isHTML(true);
    if($operacao == 'notified'){
      $mail->Subject = mb_convert_encoding($msg['protocol']. ' ' . $ticket[$quote . "protocol" . $quote] . $msg['req_att'], "ISO-8859-1", "UTF-8");
    } else {
      $mail->Subject = $msg['protocol']. ' '. $ticket[$quote . "protocol" . $quote] . ($operacao == 'created' ? $msg['generated'].'!' : $msg['updated'].'!');
    }

    if($operacao == 'notified'){
      $mail->msgHTML(
        mb_convert_encoding(
          str_replace('%OPERATION%', $operacao,
          str_replace('%PROTOCOL%', $ticket[$quote . "protocol" . $quote] . '',
          str_replace('%TICKET_TYPE%', $ticket[$quote . "id_ticket_type" . $quote] > 0 ? $ticket_types[$ticket[$quote . "id_ticket_type" . $quote]-1]['name'] : "",
          str_replace('%TICKET_THEME%', $ticket[$quote . "id_ticket_theme" . $quote] > 0 ? $themes[$ticket[$quote . "id_ticket_theme" . $quote]-1]['name'] : "",
          str_replace('%THEME_OBJECT%', $ticket[$quote . "theme_object" . $quote],
          str_replace('%CREATED%', !empty($ticket[$quote . "ticket_date_ini" . $quote]) ? date_format(date_create($ticket[$quote . "ticket_date_ini" . $quote]),DATEFORMAT) : "",
          str_replace('%FINALIZED%', !empty($ticket[$quote . "ticket_date_fin" . $quote]) ? date_format(date_create($ticket[$quote . "ticket_date_fin" . $quote]),DATEFORMAT) : "",
          str_replace('%DEADLINE_DATE%', !empty($ticket[$quote . "deadline_date" . $quote]) ? date_format(date_create($ticket[$quote . "deadline_date" . $quote]),DATEFORMAT) : "",
        file_get_contents('..\html\email-notify.html'))))))))), "ISO-8859-1", "UTF-8"), __DIR__);
    } else {
        $mail->msgHTML(
    			mb_convert_encoding(
    				str_replace('%OPERATION%', $operacao,
    	      str_replace('%PROTOCOL%', $ticket[$quote . "protocol" . $quote] . '',
    	      str_replace('%TICKET_TYPE%', $ticket[$quote . "id_ticket_type" . $quote] > 0 ? $ticket_types[$ticket[$quote . "id_ticket_type" . $quote]-1]['name'] : "",
    	      str_replace('%CHANNEL%', $ticket[$quote . "id_channel" . $quote] > 0 ? $channels[$ticket[$quote . "id_channel" . $quote]-1]['name'] : "",
    	      str_replace('%TICKET_THEME%', $ticket[$quote . "id_ticket_theme" . $quote] > 0 ? $themes[$ticket[$quote . "id_ticket_theme" . $quote]-1]['name'] : "",
            str_replace('%THEME_OBJECT%', $ticket[$quote . "theme_object" . $quote],
    	      str_replace('%COMPLAINT_THEME%', $ticket[$quote . "id_complaint_theme" . $quote] > 0 ? $themes[$ticket[$quote . "id_complaint_theme" . $quote]-1]['name'] : "",
    	      str_replace('%CONTRACT_TYPE%', $ticket[$quote . "id_contract_type" . $quote] > 0 ? $contract_types[$ticket[$quote . "id_contract_type" . $quote]-1]['name'] : "",
    	      str_replace('%CREATED%', !empty($ticket[$quote . "ticket_date_ini" . $quote]) ? date_format(date_create($ticket[$quote . "ticket_date_ini" . $quote]),DATEFORMAT) : "",
    	      str_replace('%FINALIZED%', !empty($ticket[$quote . "ticket_date_fin" . $quote]) ? date_format(date_create($ticket[$quote . "ticket_date_fin" . $quote]),DATEFORMAT) : "",
    	      str_replace('%PERSON_TYPE%', $ticket[$quote . "id_person_type" . $quote] > 0 ? $person_types[$ticket[$quote . "id_person_type" . $quote]-1]['name'] : "",
    	      str_replace('%PERSON_NAME%', $ticket[$quote . "person_name" . $quote],
    	      str_replace('%PERSON_PHONE%', $ticket[$quote . "person_phone" . $quote],
    	      str_replace('%PERSON_MAIL%', $ticket[$quote . "person_email" . $quote],
    	      str_replace('%DEADLINE_DAYS%', $ticket[$quote . "deadline_days" . $quote],
            str_replace('%DEADLINE_DATE%', !empty($ticket[$quote . "deadline_date" . $quote]) ? date_format(date_create($ticket[$quote . "deadline_date" . $quote]),DATEFORMAT) : "",
    	      str_replace('%DEADLINE_TYPE%', $ticket[$quote . "id_deadline_type" . $quote] > 0 ? $deadline_types[$ticket[$quote . "id_deadline_type" . $quote]-1]['name'] : "",
    	      str_replace('%DEADLINE_CONCLUSION%', $ticket[$quote . "id_deadline_conclusion" . $quote] > 0 ? $deadline_conclusions[$ticket[$quote . "id_deadline_conclusion" . $quote]-1]['name'] : "",
            str_replace('%REANALISYS%', $ticket[$quote . "reanalysis" . $quote] == '1' ? "Sim" : "Não",
            str_replace('%EMAILS%', $ticket[$quote . "emails" . $quote],
    	      str_replace('%OBS%', $ticket[$quote . "obs_text" . $quote],
        	file_get_contents('..\html\email.html')))))))))))))))))))))), "ISO-8859-1", "UTF-8"), __DIR__);
    }

    if (SEND_EMAILS && !$mail->send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
    }
  }
}

function notify($id = null) {
  sendTicketEmail('notified', getEmails($id), $id);

  $today = date_create('now', new DateTimeZone(TIMEZONE));
  queryUpdate("UPDATE ticket SET notified='" . $today->format("Y-m-d H:i:s") . "'WHERE id=" . $id . ";");
  header('location: index.php');
}

function getEmails($id) {
  $result = queryUnique("SELECT emails FROM ticket where id=" . $id);
	return $result['emails'];
}

function getYears() {
	global $years;
	$years = query("SELECT distinct YEAR(ticket_date_ini) ano FROM ticket ORDER BY ticket_date_ini desc");
}

function getTicketsByYear($year) {
	global $ticketsByYear;
	$ticketsByYear = query("SELECT * FROM ticket WHERE YEAR(ticket_date_ini) = '" . $year . "' ORDER BY protocol");
}

function getTicketsByReanalysis($year) {
	global $ticketsByReanalysis;
	$ticketsByReanalysis = query("SELECT COUNT(*) qtd, reanalysis
													      FROM ticket
													      WHERE YEAR(ticket_date_ini) = '" . $year . "'
													      GROUP BY reanalysis
													      ORDER BY reanalysis");
}

function getTicketsByMonth($year) {
	global $ticketsByMonth;
	$ticketsByMonth = query("SELECT COUNT(*) qtd, MONTH(ticket_date_ini) month
													 FROM ticket
													 WHERE YEAR(ticket_date_ini) = '" . $year . "'
													 GROUP BY MONTH(ticket_date_ini)
													 ORDER BY MONTH(ticket_date_ini)");
}

function getTicketsByChannel($year) {
	global $ticketsByChannel;
	$ticketsByChannel = query("SELECT c.name, (SELECT COUNT(t.id)
														 								 FROM ticket t
														 							 	 WHERE t.id_channel = c.id AND YEAR(t.ticket_date_ini) = '" . $year . "'
														 							 	 GROUP BY t.id_channel) qtd
														 FROM channel c
														 ORDER BY c.id");
}

function getTicketsByTheme($year) {
	global $ticketsByTheme;
	$ticketsByTheme = query("SELECT h.name, (SELECT COUNT(t.id)
													 								 FROM ticket t
													 							 	 WHERE t.id_ticket_theme = h.id AND YEAR(t.ticket_date_ini) = '" . $year . "'
													 							 	 GROUP BY t.id_ticket_theme) qtd FROM theme h
													 ORDER BY h.id");
}

function getTicketsByObjectTheme($year) {
	global $ticketsByObjectTheme;
	$ticketsByObjectTheme = query("SELECT t.theme_object name, COUNT(t.id) qtd
                                 FROM ticket t
                                 WHERE YEAR(t.ticket_date_ini) = '" . $year . "' and t.theme_object is not null
                                 GROUP BY t.theme_object
                                 ORDER BY t.theme_object");
}

function getTicketsByType($year) {
	global $ticketsByType;
	$ticketsByType = query("SELECT y.name, (SELECT COUNT(t.id)
																				  FROM ticket t
																					WHERE t.id_ticket_type = y.id AND YEAR(t.ticket_date_ini) = '" . $year . "'
																					GROUP BY t.id_ticket_type) qtd
													FROM ticket_type y
													ORDER BY y.id");
}

function getTicketsComplaintByTheme($year) {
	global $ticketsComplaintByTheme;
	$ticketsComplaintByTheme = query("SELECT h.name, (SELECT COUNT(t.id)
																								    FROM ticket t
																										WHERE t.id_complaint_theme = h.id AND t.id_ticket_type = '1' AND YEAR(t.ticket_date_ini) = '" . $year . "'
																										GROUP BY t.id_complaint_theme) qtd
																		FROM theme h
																		ORDER BY h.id");
}

function getTicketsComplaintByContract($year) {
	global $ticketsComplaintByContract;
	$ticketsComplaintByContract = query("SELECT c.name, (SELECT COUNT(t.id)
																								       FROM ticket t
																									     WHERE t.id_contract_type = c.id AND t.id_ticket_type = '1' AND YEAR(t.ticket_date_ini) = '" . $year . "'
																										   GROUP BY t.id_contract_type) qtd
																			 FROM contract_type c
																			 ORDER BY c.id");
}

function getTicketsComplaintByPerson($year) {
	global $ticketsComplaintByPerson;
	$ticketsComplaintByPerson = query("SELECT p.name, (SELECT COUNT(t.id)
																								     FROM ticket t
																									   WHERE t.id_person_type = p.id AND t.id_ticket_type = '1' AND YEAR(t.ticket_date_ini) = '" . $year . "'
																										 GROUP BY t.id_person_type) qtd
																		 FROM person_type p
																		 ORDER BY p.id");
}

function getTicketsByConclusion($year) {
	global $ticketsByConclusion;
	$ticketsByConclusion = query("SELECT d.name, (SELECT COUNT(t.id)
																								FROM ticket t
																								WHERE t.id_deadline_conclusion = d.id AND YEAR(t.ticket_date_ini) = '" . $year . "'
																								GROUP BY t.id_deadline_conclusion) qtd
																FROM deadline_conclusion d
																WHERE d.is_good = 0
																ORDER BY d.id");
}

function getQtdOK($year) {
	global $qtdOK;
	$qtdOK = queryUnique("SELECT count(*) qtd  FROM ticket WHERE id_deadline_conclusion = 1 AND YEAR(ticket_date_ini) = '" . $year . "'");
}

function getDaysToConclusion($year) {
	global $daysToConclusion;
	$daysToConclusion = queryUnique("SELECT SUM(DATEDIFF(ticket_date_fin, ticket_date_ini)) soma FROM ticket WHERE ticket_date_fin is not null AND YEAR(ticket_date_ini) = '" . $year . "'");
}

function getQtdOKByConclusion($year) {
	global $qtdOKByConclusion;
	$qtdOKByConclusion = query("SELECT d.id, (SELECT COUNT(t.id)
																								FROM ticket t
																								WHERE t.id_deadline_type = d.id AND t.id_deadline_conclusion = 1 AND YEAR(t.ticket_date_ini) = '" . $year . "'
																								GROUP BY t.id_deadline_type) qtd
															FROM deadline_type d
															ORDER BY d.id");
}

?>
