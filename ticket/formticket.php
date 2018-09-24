<?php
	require_once('../config/debug.php');
	require_once('functionsticket.php');
  init();
  if (empty($ticket['protocol'])) {
		$ticket['protocol'] = '';
    $ticket['id_channel'] = '';
    $ticket['id_ticket_theme'] = '';
		$ticket['theme_object'] = '';
    $ticket['ticket_date_ini'] = '';
    $ticket['ticket_date_fin'] = null;
    $ticket['id_ticket_type'] = '';
		$ticket['id_person_type'] = '';
		$ticket['person_name'] = '';
		$ticket['person_email'] = '';
		$ticket['person_phone'] = '';
		$ticket['deadline_days'] = '';
		$ticket['deadline_date'] = '';
		$ticket['id_deadline_type'] = '';
		$ticket['id_deadline_conclusion'] = '';
		$ticket['id_complaint_theme'] = '';
		$ticket['id_contract_type'] = '';
		$ticket['obs_text'] = '';
		$ticket['emails'] = '';
		$ticket['reanalysis'] = 0;
		$ticket['modified'] = '';
		$ticket['notified'] = '';
  } else{
		$originalEmails = $ticket['emails'];
	}
	if(empty($ticket['reanalysis'])){
    $ticket["'reanalysis'"] = 0;
  }
?>

<hr />
<div class="row">
	<?php if (!empty($ticket['protocol'])) : ?>
  	<div class="form-group col-md-3">
    	<label for="formProtocol"><?php echo $msg['protocol']; ?></label>
    	<input id="formProtocol" type="text" class="form-control" name="ticket['protocol']" readonly value="<?php echo $ticket['protocol']; ?>">
  	</div>
	<?php endif; ?>
	<div class="form-group col-md-3">
    <label for="formTicketType"><?php echo $msg['ticket_type']; ?>*</label>
    <select id="formTicketType" class="form-control" name="ticket['id_ticket_type']" required="true" onchange="showDivManifestacao(this)">
      <option value="" <?php if ($ticket['id_ticket_type'] == '') { echo "selected"; } ?>><?php echo $msg['select_option']; ?></option>
      <?php foreach ($ticket_types as $ticket_type) : ?>
      <?php   echo "<option value=\"{$ticket_type['id']}\""; ?>
      <?php   echo $ticket['id_ticket_type'] == $ticket_type['id'] ? "selected" : ""; ?>
      <?php   echo ">{$ticket_type['name']}</option>"; ?>
      <?php endforeach; ?>
    </select>
		<div class="help-block with-errors"></div>
  </div>
  <div class="form-group col-md-3">
    <label for="formChannel"><?php echo $msg['channel']; ?>*</label>
    <select id="formChannel" class="form-control" name="ticket['id_channel']" required="true">
      <option value="" <?php if ($ticket['id_channel'] == '') { echo "selected"; } ?>><?php echo $msg['select_option']; ?></option>
      <?php foreach ($channels as $channel) : ?>
      <?php   echo "<option value=\"{$channel['id']}\""; ?>
      <?php   echo $ticket['id_channel'] == $channel['id'] ? "selected" : ""; ?>
      <?php   echo ">{$channel['name']}</option>"; ?>
      <?php endforeach; ?>
    </select>
		<div class="help-block with-errors"></div>
  </div>
	<div class="form-group col-md-3">
    <label for="formTicketTheme"><?php echo $msg['theme']; ?>*</label>
    <select id="formTicketTheme" class="form-control" name="ticket['id_ticket_theme']" required="true">
      <option value="" <?php if ($ticket['id_ticket_theme'] == '') { echo "selected"; } ?>><?php echo $msg['select_option']; ?></option>
      <?php foreach ($themes as $theme) : ?>
      <?php   echo "<option value=\"{$theme['id']}\""; ?>
      <?php   echo $ticket['id_ticket_theme'] == $theme['id'] ? "selected" : ""; ?>
      <?php   echo ">{$theme['name']}</option>"; ?>
      <?php endforeach; ?>
    </select>
		<div class="help-block with-errors"></div>
  </div>
</div>

<div id="div_reclamacao" class="row" <?php echo $ticket['id_ticket_type'] != '1' ? "hidden": ""; ?>>
  <div class="form-group col-md-3">
    <label for="formComplaintTheme"><?php echo $msg['complaint_theme']; ?></label>
    <select id="formComplaintTheme" class="form-control" name="ticket['id_complaint_theme']">
      <option value="" <?php if ($ticket['id_complaint_theme'] == '') { echo "selected"; } ?>><?php echo $msg['select_option']; ?></option>
      <?php foreach ($themes as $complaint_theme) : ?>
      <?php   echo "<option value=\"{$complaint_theme['id']}\""; ?>
      <?php   echo $ticket['id_complaint_theme'] == $complaint_theme['id'] ? "selected" : ""; ?>
      <?php   echo ">{$complaint_theme['name']}</option>"; ?>
      <?php endforeach; ?>
    </select>
  </div>
	<div class="form-group col-md-3">
    <label for="formContractType"><?php echo $msg['contract_type']; ?></label>
    <select id="formContractType" class="form-control" name="ticket['id_contract_type']">
      <option value="" <?php if ($ticket['id_contract_type'] == '') { echo "selected"; } ?>><?php echo $msg['select_option']; ?></option>
      <?php foreach ($contract_types as $contract_type) : ?>
      <?php   echo "<option value=\"{$contract_type['id']}\""; ?>
      <?php   echo $ticket['id_contract_type'] == $contract_type['id'] ? "selected" : ""; ?>
      <?php   echo ">{$contract_type['name']}</option>"; ?>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<div class="row">
	<div class="form-group col-md-8">
    <label for="formThemeObject"><?php echo $msg['object_theme']; ?></label>
    <input id="formThemeObject" type="text" maxlength="100" class="form-control" name="ticket['theme_object']" value="<?php echo $ticket['theme_object']; ?>">
  </div>
	<div class="form-group col-md-4">
    <label for="formReanalysis">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
    <label><input id="formReanalysis" type="checkbox" name="ticket['reanalysis']" <?php if ($ticket['reanalysis'] == '1') { echo "checked"; } ?> value="1">&nbsp;<?php echo $msg['reanalysis_req']; ?></label>
  </div>
</div>

<div class="row">
  <div class="form-group col-md-3">
    <label for="formDataIni"><?php echo $msg['created']; ?>*</label>
    <input id="formDataIni" type="date" min="2000-01-01" max="2099-12-31" class="form-control" name="ticket['ticket_date_ini']"
				   <?php echo !empty($ticket['protocol']) ? "readonly" : ""; ?> required="true" onchange="calculateDeadlineDate()" value="<?php echo $ticket['ticket_date_ini']; ?>">
		<div class="help-block with-errors"></div>
  </div>
  <div class="form-group col-md-3">
    <label for="formDataFin"><?php echo $msg['finalized']; ?></label>
    <input id="formDataFin" type="date" min="2000-01-01" max="2099-12-31" class="form-control" name="ticket['ticket_date_fin']" onchange="calculateBusinessDays()"
					 value="<?php echo $ticket['ticket_date_fin']; ?>">
		<div class="help-block with-errors"></div>
  </div>
	<div class="form-group col-md-2">
    <label for="formDeadlineHidden" style="display : none"><?php echo $msg['deadline_days']; ?></label>
    <input id="formDeadlineHidden" style="display : none" type="text" data-mask="000" class="form-control" readonly value="">
  </div>
</div>

<div class="row">
  <div class="form-group col-md-2">
    <label for="formDeadlineDays"><?php echo $msg['business_days']; ?></label>
    <input id="formDeadlineDays" type="text" data-mask="000" class="form-control" name="ticket['deadline_days']" readonly value="<?php echo $ticket['deadline_days']; ?>">
  </div>
	<div class="form-group col-md-2">
    <label for="formDeadlineDate"><?php echo $msg['limit_date']; ?></label>
		<input id="formDeadlineDate" type="date" min="2000-01-01" max="2099-12-31" class="form-control" name="ticket['deadline_date']" onchange="calculateDeadlineType()"
			     value="<?php echo $ticket['deadline_date']; ?>">
  </div>
	<div class="form-group col-md-2">
    <label for="formDeadlineType"><?php echo $msg['deadline_type']; ?></label>
    <select id="formDeadlineType" class="form-control" name="ticket['id_deadline_type']">
      <option value="" <?php if ($ticket['id_deadline_type'] == '') { echo "selected"; } ?>><?php echo $msg['select_option']; ?></option>
      <?php foreach ($deadline_types as $deadline_type) : ?>
      <?php   echo "<option value=\"{$deadline_type['id']}\""; ?>
      <?php   echo $ticket['id_deadline_type'] == $deadline_type['id'] ? "selected" : ""; ?>
      <?php   echo ">{$deadline_type['name']}</option>"; ?>
      <?php endforeach; ?>
    </select>
  </div>
	<div class="form-group col-md-6">
    <label for="formDeadlineConc"><?php echo $msg['deadline_conclusion']; ?></label>
    <select id="formDeadlineConc" class="form-control" name="ticket['id_deadline_conclusion']">
      <option value="" <?php if ($ticket['id_deadline_conclusion'] == '') { echo "selected"; } ?>><?php echo $msg['select_option']; ?></option>
      <?php foreach ($deadline_conclusions as $deadline_conclusion) : ?>
      <?php   echo "<option value=\"{$deadline_conclusion['id']}\""; ?>
      <?php   echo $ticket['id_deadline_conclusion'] == $deadline_conclusion['id'] ? "selected" : ""; ?>
      <?php   echo ">{$deadline_conclusion['name']}</option>"; ?>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<div class="row">
  <div class="form-group col-md-4">
    <label for="formPersonType"><?php echo $msg['person_type']; ?></label>
    <select id="formPersonType" class="form-control" name="ticket['id_person_type']">
      <option value="" <?php if ($ticket['id_person_type'] == '') { echo "selected"; } ?>><?php echo $msg['select_option']; ?></option>
      <?php foreach ($person_types as $person_type) : ?>
      <?php   echo "<option value=\"{$person_type['id']}\""; ?>
      <?php   echo $ticket['id_person_type'] == $person_type['id'] ? "selected" : ""; ?>
      <?php   echo ">{$person_type['name']}</option>"; ?>
      <?php endforeach; ?>
    </select>
  </div>
	<div class="form-group col-md-8">
    <label for="formPersonName"><?php echo $msg['person_name']; ?></label>
    <input id="formPersonName" type="text" maxlength="100" class="form-control" name="ticket['person_name']" value="<?php echo $ticket['person_name']; ?>">
  </div>
</div>

<div class="row">
	<div class="form-group col-md-6">
    <label for="formPersonPhone"><?php echo $msg['person_phone']; ?></label>
		<input id="formPersonPhone" type="text" maxlength="100" class="form-control" name="ticket['person_phone']" value="<?php echo $ticket['person_phone']; ?>">
  </div>
	<div class="form-group col-md-6">
    <label for="formPersonMail"><?php echo $msg['person_email']; ?></label>
    <input id="formPersonMail" type="email" class="form-control" name="ticket['person_email']" value="<?php echo $ticket['person_email']; ?>">
		<div class="help-block with-errors"></div>
  </div>
</div>

<div class="row">
  <div class="form-group col-md-8">
    <label for="formEmails"><?php echo $msg['emails_notify']; ?>&nbsp;</label>
    <input id="formEmails" type="text" class="form-control" maxlength="300" data-role="tagsinput" name="ticket['emails']" value="<?php echo $ticket['emails']; ?>"
			<?php echo !empty($ticket['protocol']) ? 'onchange="verifyBtnNotify(this, \'' . $originalEmails .'\')"': ''; ?> >
  </div>
	<?php if (!empty($ticket['protocol'])) : ?>
		<div class="form-group col-md-4">
	    <label for="formNotified"><?php echo $msg['last_notify']; ?></label>
	    <input id="formNotified" type="text" class="form-control" readonly name="ticket['notified']"
				value="<?php echo (!empty($ticket['notified']) && date_format(date_create($ticket['notified']), DATEFORMAT) != '30/11/-0001 00:00:00') ? date_format(date_create($ticket['notified']),"d/m/Y H:i:s") : null; ?>">
	  </div>
	<?php endif; ?>
</div>

<div class="row">
  <div class="form-group col-md-12">
    <label for="formObs"><?php echo $msg['obs']; ?></label>
    <textarea id="formObs" class="form-control" name="ticket['obs_text']" rows="5"><?php echo $ticket['obs_text']; ?></textarea>
  </div>
</div>
