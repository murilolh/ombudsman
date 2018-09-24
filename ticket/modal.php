<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel"></h4>
      </div>
      <div class="modal-body">
        <?php echo $msg['delete_ticket'];?>
      </div>
      <div class="modal-footer">
        <a id="confirm" class="btn btn-primary" href="#"><?php echo $msg['option_yes'];?></a>
        <a id="cancel" class="btn btn-default" data-dismiss="modal"><?php echo $msg['option_no'];?></a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="notify-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel"></h4>
      </div>
      <div class="modal-body">
        <?php echo $msg['notify_emails_prompt'];?>
      </div>
      <div class="modal-footer">
        <a id="confirm" class="btn btn-primary" href="#"><?php echo $msg['option_yes'];?></a>
        <a id="cancel" class="btn btn-default" data-dismiss="modal"><?php echo $msg['option_no'];?></a>
      </div>
    </div>
  </div>
</div>
