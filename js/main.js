$('#delete-modal').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget);
  var id = button.data('ticket');
  var protocol = button.data('protocol');

  var modal = $(this);
  modal.find('.modal-title').text('Delete Ticket ' + protocol);
  modal.find('#confirm').attr('href', 'deleteticket.php?id=' + id);
})

$('#notify-modal').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget);
  var id = button.data('ticket');
  var protocol = button.data('protocol');

  var modal = $(this);
  modal.find('.modal-title').text('Noify Ticket ' + protocol);
  modal.find('#confirm').attr('href', 'notifyticket.php?id=' + id);
})

function showDivManifestacao(elem){
  if(elem.value == 1){
    document.getElementById('div_reclamacao').style.display = "block";
  } else {
    document.getElementById('div_reclamacao').style.display = "none";
    document.getElementById('formComplaintTheme').value = "";
    document.getElementById('formContractType').value = "";
  }
}

function calculateDeadlineDate(){
  var dateIni = document.getElementById('formDataIni').value;
  var deadlineDays = document.getElementById('formDeadlineHidden').value;

  if(deadlineDays == 0){
    deadlineDays = 7;
    document.getElementById('formDeadlineHidden').value = deadlineDays;
    document.getElementById('formDeadlineType').value = 1;
  }

  if(dateIni && deadlineDays){
    var result = new Date(dateIni.substring(0, 4), dateIni.substring(5, 7) - 1, dateIni.substring(8, 10));
    var iDeadlineDays = parseInt(deadlineDays);
    while(iDeadlineDays > 0){
      if(isBusinessDay(result)){
        iDeadlineDays--;
      }
      result.setDate(result.getDate() + 1);
    }
    result.setDate(result.getDate() - 1);
    document.getElementById('formDeadlineDate').value = result.getFullYear() + '-' + zeroFill(result.getMonth()+1,2) + '-' + zeroFill(result.getDate(),2);
  }
  calculateBusinessDays();

}

function calculateBusinessDays(){
  var dateIni = document.getElementById('formDataIni').value;
  var dateFin = document.getElementById('formDataFin').value;

  if(dateIni && dateFin && (dateFin >= dateIni)){
    var deadlineDays = 1;
    var result = new Date(dateIni.substring(0, 4), dateIni.substring(5, 7) - 1, dateIni.substring(8, 10));
    var date = new Date(dateFin.substring(0, 4), dateFin.substring(5, 7) - 1, dateFin.substring(8, 10));

    while(result < date){
      result.setDate(result.getDate() + 1);
      if(isBusinessDay(result)){
        deadlineDays++;
      }
    }

    document.getElementById('formDeadlineDays').value = deadlineDays;
  } else {
    document.getElementById('formDeadlineDays').value = null;
  }
}

function calculateDeadlineType(){
  var dateIni = document.getElementById('formDataIni').value;
  var dateDeadline = document.getElementById('formDeadlineDate').value;

  if(dateIni && dateDeadline && (dateDeadline >= dateIni)){
    var deadlineDays = 1;
    var result = new Date(dateIni.substring(0, 4), dateIni.substring(5, 7) - 1, dateIni.substring(8, 10));
    var date = new Date(dateDeadline.substring(0, 4), dateDeadline.substring(5, 7) - 1, dateDeadline.substring(8, 10));

    while(result < date){
      result.setDate(result.getDate() + 1);
      if(isBusinessDay(result)){
        deadlineDays++;
      }
    }

    var deadlineType = null;
    if(deadlineDays <= 7){
      deadlineType = 1;
    } else if(deadlineDays <= 30){
      deadlineType = 3;
    } else {
      deadlineType = 2;
    }

    document.getElementById('formDeadlineType').value = deadlineType;
  } else {
    document.getElementById('formDeadlineType').value = null;
  }
}

function isBusinessDay(day){
  var dayOfWeek = day.getDay();
  if(dayOfWeek == 6 || dayOfWeek == 0 || isHoliday(day)){ // Saturday or Sunday or Holidays
    return false;
  }
  return true;
}

function isHoliday(day){
  return false;
}

function changePage(page){
  document.getElementById('formFilterPage').value = page;
  document.getElementById('formTicket').submit();
}

function verifyBtnNotify(emails, originalEmails){
  if(emails.value != '' && emails.value == originalEmails){
    document.getElementById('btnNotify').style.display = "inline";
    document.getElementById('btnNotify').style.visibility = "";
  } else {
    document.getElementById('btnNotify').style.display = "none";
    document.getElementById('btnNotify').style.visibility = "hidden";
  }
}

function zeroFill( number, width ){
  width -= number.toString().length;
  if ( width > 0 ){
    return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
  }
  return number + "";
}

function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}

document.onkeypress = stopRKey;
