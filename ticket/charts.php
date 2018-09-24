<?php
  require_once('../config/debug.php');
  require_once('functionsticket.php');
  $msg = require '../const/strings.php';
  getYears();
  if (!empty($_POST['filter'])) {
    $filter = $_POST['filter'];
    $filter['year'] = $filter["'year'" ];

    getTicketsByReanalysis($filter['year']);
    getTicketsByMonth($filter['year']);
    getTicketsByChannel($filter['year']);
    getTicketsByTheme($filter['year']);
    getTicketsByType($filter['year']);
    getQtdOKByConclusion($filter['year']);
    getTicketsByConclusion($filter['year']);
  } else {
    $filter['year'] = '';
  }
?>

<?php include(HEADER_TEMPLATE); ?>

<head>
  <script type="text/javascript" src="<?php echo BASEURL; ?>js/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

      var dataMonth = google.visualization.arrayToDataTable([
        ['<?php echo $msg['month_msg']; ?>', '<?php echo $msg['tickets']; ?>'],
        <?php
          $monthDB = 0;
          for ($monthArray = 0; $monthArray < 12; $monthArray++) {
              $comma = "";
              if($monthArray < 11){
                $comma = ",";
              }

              if(count($ticketsByMonth) > $monthDB && $ticketsByMonth[$monthDB]['month'] == ($monthArray + 1)){
                echo "['" . $msg['arrayMonths'][$monthArray] . "', " . $ticketsByMonth[$monthDB]['qtd'] . "]" . $comma;
                $monthDB++;
              } else {
                echo "['" . $msg['arrayMonths'][$monthArray] . "', 0]" . $comma;
              }
          }?>
      ]);

      var optionsMonth = {
        title: '<?php echo $msg['tickets_by'] .' '. $msg['month_msg']; ?> - <?php echo $filter['year'];?>',
        hAxis: {title: '<?php echo $msg['month_msg']; ?>',  titleTextStyle: {color: '#333'}},
        vAxis: {minValue: 0}
      };

      var chartMonth = new google.visualization.AreaChart(document.getElementById('chartMonth'));
      chartMonth.draw(dataMonth, optionsMonth);

      var dataChannel = new google.visualization.DataTable();
      dataChannel.addColumn('string', '<?php echo $msg['channel']; ?>');
      dataChannel.addColumn('number', 'Qtd');
      dataChannel.addRows([
        <?php
          $i = 1;
          foreach ($ticketsByChannel as $ticketByChannel) :
            $comma = "";
            if($i != count($ticketsByChannel)){
              $comma = ",";
            }
            echo "['" . $ticketByChannel['name'] . "', " . ($ticketByChannel['qtd'] ? $ticketByChannel['qtd'] : 0) . "]" . $comma;
            $i++;
          endforeach;?>
      ]);

      var optionsChannel = {'title':'<?php echo $msg['tickets_by'] .' '. $msg['channel']; ?> - <?php echo $filter['year'];?>',
                            'is3D': true,
                            'width':600,
                            'height':450};

      var chartChannel = new google.visualization.PieChart(document.getElementById('chartChannel'));
      chartChannel.draw(dataChannel, optionsChannel);

      var dataTheme = new google.visualization.DataTable();
      dataTheme.addColumn('string', 'Tema');
      dataTheme.addColumn('number', 'Qtd');
      dataTheme.addRows([
        <?php
          $i = 1;
          foreach ($ticketsByTheme as $ticketByTheme) :
            $comma = "";
            if($i != count($ticketsByTheme)){
              $comma = ",";
            }
            echo "['" . $ticketByTheme['name'] . "', " . ($ticketByTheme['qtd'] ? $ticketByTheme['qtd'] : 0) . "]" . $comma;
            $i++;
          endforeach;?>
      ]);

      var optionsTheme = {'title':'<?php echo $msg['tickets_by'] .' '. $msg['theme']; ?> - <?php echo $filter['year'];?>',
                          'is3D': true,
                          'width':600,
                          'height':450};

      var chartTheme = new google.visualization.PieChart(document.getElementById('chartTheme'));
      chartTheme.draw(dataTheme, optionsTheme);

      var dataType = new google.visualization.DataTable();
      dataType.addColumn('string', 'Type');
      dataType.addColumn('number', 'Qtd');
      dataType.addRows([
        <?php
          $i = 1;
          foreach ($ticketsByType as $ticketByType) :
            $comma = "";
            if($i != count($ticketsByType)){
              $comma = ",";
            }
            echo "['" . $ticketByType['name'] . "', " . ($ticketByType['qtd'] ? $ticketByType['qtd'] : 0) . "]" . $comma;
            $i++;
          endforeach;?>
      ]);

      var optionsType = {'title':'<?php echo $msg['tickets_by'] .' '. $msg['type']; ?> - <?php echo $filter['year'];?>',
                          'is3D': true,
                          'width':600,
                          'height':450};

      var chartType = new google.visualization.PieChart(document.getElementById('chartType'));
      chartType.draw(dataType, optionsType);

      var dataReanalysyis = new google.visualization.DataTable();
      dataReanalysyis.addColumn('string', 'Type');
      dataReanalysyis.addColumn('number', 'Qtd');
      dataReanalysyis.addRows([['<?php echo $msg['option_yes'];?>', <?php
                                         $total = 0;
                                         foreach ($ticketsByReanalysis as $ticketByReanalysis) :
                                           if($ticketByReanalysis['reanalysis'] == '1') {
                                             $total = $total + $ticketByReanalysis['qtd'];
                                           }
                                         endforeach;

                                         echo $total;?>],
                               ['<?php echo $msg['option_no'];?>', <?php
                                        $total = 0;
                                        foreach ($ticketsByReanalysis as $ticketByReanalysis) :
                                          if(empty($ticketByReanalysis['reanalysis']) || $ticketByReanalysis['reanalysis'] == '0') {
                                            $total = $total + $ticketByReanalysis['qtd'];
                                          }
                                        endforeach;

                                        echo $total;?>]
      ]);

      var optionsReanalysyis = {'title':'<?php echo $msg['reanalysis_req'];?> - <?php echo $filter['year'];?>',
                                'is3D': true,
                                'width':600,
                                'height':450};

      var chartReanalysyis = new google.visualization.PieChart(document.getElementById('chartReanalysyis'));
      chartReanalysyis.draw(dataReanalysyis, optionsReanalysyis);

      var dataConclusionType = new google.visualization.DataTable();
      dataConclusionType.addColumn('string', 'Type');
      dataConclusionType.addColumn('number', 'Qtd');
      dataConclusionType.addRows([['<?php echo $msg['chart_inside'];?>', <?php
                                                               foreach ($qtdOKByConclusion as $qtd) :
                                                                 if($qtd['id'] == 1){
                                                                   echo ($qtd['qtd'] ? $qtd['qtd'] : 0);
                                                                 }
                                                               endforeach;?>],
                               ['<?php echo $msg['chart_inside_agreed'];?>', <?php
                                                                      foreach ($qtdOKByConclusion as $qtd) :
                                                                        if($qtd['id'] == 3){
                                                                          echo ($qtd['qtd'] ? $qtd['qtd'] : 0);
                                                                        }
                                                                      endforeach;?>],
                               ['<?php echo $msg['chart_outside'];?>', <?php
                                                          foreach ($qtdOKByConclusion as $qtd) :
                                                            if($qtd['id'] == 2){
                                                              echo ($qtd['qtd'] ? $qtd['qtd'] : 0);
                                                            }
                                                          endforeach;?>]
      ]);

      var optionsConclusionType = {'title':'<?php echo $msg['tickets_by'] .' '. $msg['response_type']; ?> - <?php echo $filter['year'];?>',
                                    'is3D': true,
                                    'width':600,
                                    'height':450};

      var chartConclusionType = new google.visualization.PieChart(document.getElementById('chartConclusionType'));
      chartConclusionType.draw(dataConclusionType, optionsConclusionType);

      var dataConclusion = new google.visualization.DataTable();
      dataConclusion.addColumn('string', 'Type');
      dataConclusion.addColumn('number', 'Qtd');
      dataConclusion.addRows([<?php
                                foreach ($ticketsByConclusion as $ticketByConclusion) :
                                  $comma = "";
                                  if($i != count($ticketsByConclusion)){
                                    $comma = ",";
                                  }
                                  echo "['" . $ticketByConclusion['name'] . "', " . ($ticketByConclusion['qtd'] ? $ticketByConclusion['qtd'] : 0) . "]" . $comma;
                                  $i++;
                                endforeach;?>
      ]);

      var optionsConclusion = {'title':'<?php echo $msg['motive_deadline'] ?> - <?php echo $filter['year'];?>',
                                'is3D': true,
                                'width':600,
                                'height':450};

      var chartConclusion = new google.visualization.PieChart(document.getElementById('chartConclusion'));
      chartConclusion.draw(dataConclusion, optionsConclusion);
    }
  </script>
</head>

<header>
	<div class="row">
		<div class="col-sm-6">
			<h2><?php echo $msg['charts']; ?></h2>
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
<form action="charts.php" data-toggle="validator" method="post">

  <div>
    <div class="row">
      <div class="form-group col-md-offset-5 col-md-2 text-center">
        <label for="formReportYear"><?php echo $msg['year_msg']; ?>*</label>
        <select id="formTicketType" class="form-control text-center" required="true" name="filter['year']">
          <option value=""><?php echo $msg['select_option']; ?></option>
          <?php foreach ($years as $year) : ?>
          <?php   echo "<option value=\"{$year['ano']}\""; ?>
          <?php   echo ">{$year['ano']}</option>"; ?>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div id="actions" class="row">
      <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary"><?php echo $msg['generate']; ?></button>
      </div>
    </div>
  </div>


  <?php if (!empty($_POST['filter'])) : ?>
    <hr>
    <div class="row">
      <div id="chartMonth"></div>
    </div>
    <div class="row">
      <div id="chartReanalysyis" class="col-md-6"></div>
      <div id="chartTheme" class="col-md-6"></div>
    </div>
    <div class="row">
      <div id="chartChannel" class="col-md-6"></div>
      <div id="chartType" class="col-md-6"></div>
    </div>
    <div class="row">
      <div id="chartConclusionType" class="col-md-6"></div>
      <div id="chartConclusion" class="col-md-6"></div>
    </div>
  <?php endif; ?>
</form>

<?php include(FOOTER_TEMPLATE); ?>
