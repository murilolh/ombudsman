<?php
  require_once('../config/debug.php');
  require_once('functionsticket.php');
  $msg = require '../const/strings.php';
  if (!empty($_POST['filter'])) {
    $filter = $_POST['filter'];
    $filter['year'] = $filter["'year'" ];

    getTicketsByReanalysis($filter['year']);
    getTicketsByMonth($filter['year']);
    getTicketsByChannel($filter['year']);
    getTicketsByTheme($filter['year']);
    getTicketsByType($filter['year']);
    getTicketsComplaintByTheme($filter['year']);
    getTicketsComplaintByContract($filter['year']);
    getTicketsComplaintByPerson($filter['year']);
    getTicketsByConclusion($filter['year']);
    getQtdOK($filter['year']);
    getDaysToConclusion($filter['year']);
    getQtdOKByConclusion($filter['year']);
  } else {
    $filter['year'] = '';
  }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo SYSTEMNAME .' - '. $msg['report']; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      table, td, th {
          border: 2px solid grey;
      }
      th {
          width: 70%;
          text-align: left;
      }
      table {
          border-collapse: collapse;
          width: 100%;
      }
    </style>
</head>
<header>
	<div class="row">
		<div class="col-sm-6">
			<h2><?php echo SYSTEMNAME .' - '. $msg['report']; ?></h2>
		</div>
	</div>
</header>
<body>
  <table>
    <tr>
      <th colspan="2" style="background-color: #f2f2f2;text-align:center"><?php echo SYSTEMNAME .' - '. $msg['report']; ?></th>
    </tr>
    <tr>
      <th><?php echo $msg['year_msg'];?></th>
      <td><?php echo $filter['year'];?></td>
    </tr>
    <tr>
      <th><?php echo $msg['operator_id'];?></th>
      <td><?php echo $msg['operator_id_value'];?></td>
    </tr>
    <tr>
      <th><?php echo $msg['operator_reg'];?></th>
      <td><?php echo $msg['operator_reg_value'];?></td>
    </tr>
    <tr>
      <th><?php echo $msg['operator_type'];?></th>
      <td><?php echo $msg['operator_type_value'];?></td>
    </tr>
    <tr>
      <th><?php echo $msg['operator_email'];?></th>
      <td><?php echo $msg['operator_email_value'];?></td>
    </tr>
    <tr>
      <th><?php echo $msg['operator_phone'];?></th>
      <td><?php echo $msg['operator_phone_value'];?></td>
    </tr>
  </table>
  <br>
  <table>
    <tr>
      <th colspan="2" style="background-color: #f2f2f2;text-align:center"><?php echo $msg['reanalysis_req'];?></th>
    </tr>
    <tr>
      <th><?php echo $msg['option_yes'];?></th>
      <td><?php
           $total = 0;
           foreach ($ticketsByReanalysis as $ticketByReanalysis) :
             if($ticketByReanalysis['reanalysis'] == '1') {
               $total = $total + $ticketByReanalysis['qtd'];
             }
           endforeach;

           echo $total;?></td>
    </tr>
    <tr>
      <th><?php echo $msg['option_no'];?></th>
      <td><?php
           $total = 0;
           foreach ($ticketsByReanalysis as $ticketByReanalysis) :
             if(empty($ticketByReanalysis['reanalysis']) || $ticketByReanalysis['reanalysis'] == '0') {
               $total = $total + $ticketByReanalysis['qtd'];
             }
           endforeach;

           echo $total;?></td>
    </tr>
  </table>
  <br>
  <table>
    <tr>
      <th colspan="2" style="background-color: #f2f2f2;text-align:center"><?php echo $msg['tickets_received_year'];?></th>
    </tr>
    <tr>
      <th><?php echo $msg['option_yes'];?></th>
      <td><?php
           $total = 0;
           foreach ($ticketsByMonth as $ticketByMonth) :
             $total = $total + $ticketByMonth['qtd'];
           endforeach;

           echo $total;?></td>
    </tr>
    <tr>
      <th><?php echo $msg['option_no'];?></th>
      <td>-</td>
    </tr>
    <?php
      $monthDB = 0;
      for ($monthArray = 0; $monthArray < 12; $monthArray++) {
          echo "  <th>" . $msg['arrayMonths'][$monthArray] . "</th>";
          if(count($ticketsByMonth) > $monthDB && $ticketsByMonth[$monthDB]['month'] == ($monthArray + 1)){
            echo "  <td>" . $ticketsByMonth[$monthDB]['qtd'] . "</td>";
            $monthDB++;
          } else {
            echo "  <td>0</td>";
          }
          echo "</tr>";
      }?>
      <tr>
        <th><?php echo $msg['total'];?></th>
        <td><?php echo $total;?></td>
      </tr>
      <tr>
        <th>&nbsp;</th>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <th><?php echo $msg['tickets_received_year_by']. $msg['channel']; ?></th>
        <td><?php
              $total = 0;
              foreach ($ticketsByChannel as $ticketByChannel) :
                $total = $total + $ticketByChannel['qtd'];
              endforeach;

              echo $total;?></td>
      </tr>
      <?php
        foreach ($ticketsByChannel as $ticketByChannel) :
          echo "<tr>";
          echo "  <th>". $ticketByChannel['name'] ."</th>";
          echo "  <td>" . ($ticketByChannel['qtd'] ? $ticketByChannel['qtd'] : 0) . "</td>";
          echo "</tr>";
        endforeach;?>
      <tr>
        <th>&nbsp;</th>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <th><?php echo $msg['tickets_received_year_by']. $msg['theme']; ?></th>
        <td><?php
              $total = 0;
              foreach ($ticketsByTheme as $ticketByTheme) :
                $total = $total + $ticketByTheme['qtd'];
              endforeach;

              echo $total;?></td>
      </tr>
      <?php
        foreach ($ticketsByTheme as $ticketByTheme) :
          echo "<tr>";
          echo "  <th>". $ticketByTheme['name'] ."</th>";
          echo "  <td>" . ($ticketByTheme['qtd'] ? $ticketByTheme['qtd'] : 0) . "</td>";
          echo "</tr>";
        endforeach;?>
      <tr>
        <th>&nbsp;</th>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <th><?php echo $msg['tickets_received_year_by']. $msg['ticket_type']; ?></th>
        <td><?php
              $total = 0;
              foreach ($ticketsByType as $ticketByType) :
                $total = $total + $ticketByType['qtd'];
              endforeach;

              echo $total;?></td>
      </tr>
      <?php
        foreach ($ticketsByType as $ticketByType) :
          echo "<tr>";
          echo "  <th>". $ticketByType['name'] ."</th>";
          echo "  <td>" . ($ticketByType['qtd'] ? $ticketByType['qtd'] : 0) . "</td>";
          echo "</tr>";
        endforeach;?>
      <tr>
        <th>&nbsp;</th>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <th><?php echo $msg['complaints_by']. $msg['theme']; ?></th>
        <td><?php
              $total = 0;
              foreach ($ticketsComplaintByTheme as $ticketComplaintByTheme) :
                $total = $total + $ticketComplaintByTheme['qtd'];
              endforeach;

              echo $total;?></td>
      </tr>
      <?php
        foreach ($ticketsComplaintByTheme as $ticketComplaintByTheme) :
          echo "<tr>";
          echo "  <th>". $ticketComplaintByTheme['name'] ."</th>";
          echo "  <td>" . ($ticketComplaintByTheme['qtd'] ? $ticketComplaintByTheme['qtd'] : 0) . "</td>";
          echo "</tr>";
        endforeach;?>
      <tr>
        <th>&nbsp;</th>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <th><?php echo $msg['complaints_by']. $msg['contract_type']; ?></th>
        <td><?php
              $total = 0;
              foreach ($ticketsComplaintByContract as $ticketComplaintByContract) :
                $total = $total + $ticketComplaintByContract['qtd'];
              endforeach;

              echo $total;?></td>
      </tr>
      <?php
        foreach ($ticketsComplaintByContract as $ticketComplaintByContract) :
          echo "<tr>";
          echo "  <th>". $ticketComplaintByContract['name'] ."</th>";
          echo "  <td>" . ($ticketComplaintByContract['qtd'] ? $ticketComplaintByContract['qtd'] : 0) . "</td>";
          echo "</tr>";
        endforeach;?>
      <tr>
        <th>&nbsp;</th>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <th><?php echo $msg['complaints_by']. $msg['person_type']; ?></th>
        <td><?php
              $total = 0;
              foreach ($ticketsComplaintByPerson as $ticketComplaintByPerson) :
                $total = $total + $ticketComplaintByPerson['qtd'];
              endforeach;

              echo $total;?></td>
      </tr>
      <?php
        foreach ($ticketsComplaintByPerson as $ticketComplaintByPerson) :
          echo "<tr>";
          echo "  <th>". $ticketComplaintByPerson['name'] ."</th>";
          echo "  <td>" . ($ticketComplaintByPerson['qtd'] ? $ticketComplaintByPerson['qtd'] : 0) . "</td>";
          echo "</tr>";
        endforeach;?>
  </table>
  <br>
  <table>
    <tr>
      <th colspan="2" style="background-color: #f2f2f2;text-align:center"><?php echo $msg['indicators']; ?></th>
    </tr>
    <tr>
      <th><?php echo $msg['response_time']; ?></th>
      <td><?php echo $qtdOK['qtd'] != 0 ? $daysToConclusion['soma'] / $qtdOK['qtd'] : 0;?></td>
    </tr>
    <tr>
      <th><?php echo $msg['numerator']; ?></th>
      <td><?php echo $daysToConclusion['soma'] != null ? $daysToConclusion['soma'] : 0;?></td>
    </tr>
    <tr>
      <th><?php echo $msg['denominator']; ?></th>
      <td><?php echo $qtdOK['qtd'];?></td>
    </tr>
    <tr>
      <th>&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th><?php echo $msg['response_inside']; ?></th>
      <td><?php
            $value = 0;
            foreach ($qtdOKByConclusion as $qtd) :
              if($qtd['id'] == 1){
                $value = ($qtd['qtd'] ? $qtd['qtd'] : 0);
              }
            endforeach;
            echo $qtdOK['qtd'] != 0  ? ($value / $qtdOK['qtd'])*100 : 0;?>%</td>
    </tr>
    <tr>
      <th><?php echo $msg['numerator']; ?></th>
      <td><?php
           foreach ($qtdOKByConclusion as $qtd) :
             if($qtd['id'] == 1){
               echo ($qtd['qtd'] ? $qtd['qtd'] : 0);
             }
           endforeach;?></td>
    </tr>
    <tr>
      <th><?php echo $msg['denominator']; ?></th>
      <td><?php echo $qtdOK['qtd'];?></td>
    </tr>
    <tr>
      <th>&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th><?php echo $msg['response_inside_agreed']; ?></th>
      <td><?php
            $value = 0;
            foreach ($qtdOKByConclusion as $qtd) :
              if($qtd['id'] == 3){
                $value = ($qtd['qtd'] ? $qtd['qtd'] : 0);
              }
            endforeach;
            echo $qtdOK['qtd'] != 0  ? ($value / $qtdOK['qtd'])*100 : 0;?>%</td>
    </tr>
    <tr>
      <th><?php echo $msg['numerator']; ?></th>
      <td><?php
           foreach ($qtdOKByConclusion as $qtd) :
             if($qtd['id'] == 3){
               echo ($qtd['qtd'] ? $qtd['qtd'] : 0);
             }
           endforeach;?></td>
    </tr>
    <tr>
      <th><?php echo $msg['denominator']; ?></th>
      <td><?php echo $qtdOK['qtd'];?></td>
    </tr>
    <tr>
      <th>&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th><?php echo $msg['response_outside']; ?></th>
      <td><?php
            $value = 0;
            foreach ($qtdOKByConclusion as $qtd) :
              if($qtd['id'] == 2){
                $value = ($qtd['qtd'] ? $qtd['qtd'] : 0);
              }
            endforeach;
            echo $qtdOK['qtd'] != 0  ? ($value / $qtdOK['qtd'])*100 : 0;?>%</td>
    </tr>
    <tr>
      <th><?php echo $msg['numerator']; ?></th>
      <td><?php
           foreach ($qtdOKByConclusion as $qtd) :
             if($qtd['id'] == 2){
               echo ($qtd['qtd'] ? $qtd['qtd'] : 0);
             }
           endforeach;?></td>
    </tr>
    <tr>
      <th><?php echo $msg['denominator']; ?></th>
      <td><?php echo $qtdOK['qtd'];?></td>
    </tr>
    <tr>
      <th>&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th><?php echo $msg['motive_deadline']; ?></th>
      <td>&nbsp;</td>
    </tr>
    <?php
      foreach ($ticketsByConclusion as $ticketByConclusion) :
        echo "<tr>";
        echo "  <th>". $ticketByConclusion['name'] ."</th>";
        echo "  <td>" . ($ticketByConclusion['qtd'] ? $ticketByConclusion['qtd'] : 0) . "</td>";
        echo "</tr>";
      endforeach;?>
  </table>
  <br>
</body>
</html>
