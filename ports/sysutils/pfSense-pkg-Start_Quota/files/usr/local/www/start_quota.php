<?php
/*
 Copyright 2016 Battams, Derek
 
	Licensed under the Apache License, Version 2.0 (the "License");
	you may not use this file except in compliance with the License.
	You may obtain a copy of the License at
 
		http://www.apache.org/licenses/LICENSE-2.0
 
	Unless required by applicable law or agreed to in writing, software
	distributed under the License is distributed on an "AS IS" BASIS,
	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	See the License for the specific language governing permissions and
	limitations under the License.
*/
require("guiconfig.inc");
require('start_quota.inc');

define('COLOR', true);

if(!isConfigured())
	header("Location: /pkg_edit.php?xml=start-quota.xml&id=0");

$API_KEY = getApiKey();
try {
	$xml = new SimpleXMLElement(getXmlData());
} catch(Exception $e) {
	session_start();
	$_SESSION['START_QUOTA_ERROR'] = $e;
	header("Location: /start_quota_nodata.php");	
}
$pgtitle = array(gettext("Start.ca"), gettext("Quota"));
include("head.inc");
$tabs = array();
$tabs[] = array(gettext("Settings"), false, "/pkg_edit.php?xml=start-quota.xml&id=0");
display_top_tabs($tabs);
?>

<div class="panel panel-default">
	<div class="panel-heading"><h2 class="panel-title">Data current as of <?= date('D, j M Y G:i T', getDataDate()) ?></h2></div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>Type</th>
					<th>Download</th>
					<th>Upload</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Billed</td>
					<td><?= formatBytes($xml->used->download) ?></td>
					<td><?= formatBytes($xml->used->upload) ?></td>
					<td><?= formatBytes($xml->used->download + $xml->used->upload) ?></td>
				</tr>
				<tr>
					<td>Free</td>
					<td><?= formatBytes($xml->grace->download) ?></td>
					<td><?= formatBytes($xml->grace->upload) ?></td>
					<td><?= formatBytes($xml->grace->download + $xml->grace->upload) ?></td>
				</tr> 
				<tr>
					<td><b>TOTAL</b></td>
					<td><b><?= formatBytes($xml->total->download) ?></b></td>
					<td><b><?= formatBytes($xml->total->upload) ?></b></td>
					<td><b><?= formatBytes($xml->total->download + $xml->total->upload) ?></b></td>
				</tr>
			</tbody>
		</table>
		<?php if(getQuota() > 0) echo "<div><b>Remaining Quota: " . formatBytes(getQuota() - $xml->used->download - $xml->used->upload) . "</b></div>" ?>
		<span id="quota_div"></span>
                <span id="usage_div"></span>
	</div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawCharts);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawCharts() {
	<?php if(getQuota() > 0) echo 'drawRemainingQuotaChart();' ?>
	drawDataUsageChart();
      }

      function drawDataUsageChart() {
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Data Type');
        data.addColumn('number', 'Bytes');
        data.addColumn({type: 'string', role: 'tooltip'});
        data.addRows([
          ['Billed Upload', <?= $xml->used->upload ?>, '<?= formatBytes($xml->used->upload) ?>'],
          ['Billed Download', <?= $xml->used->download ?>, '<?= formatBytes($xml->used->download) ?>'],
	   ['Free Upload', <?= $xml->grace->upload ?>, '<?= formatBytes($xml->grace->upload) ?>'],
           ['Free Download', <?= $xml->grace->download ?>, '<?= formatBytes($xml->grace->download) ?>']
        ]);

        // Set chart options
        var options = {'title':'Data Usage for Current Billing Period',
                       'width':850,
                       'height':350};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('usage_div'));
        chart.draw(data, options);
      }

      function drawRemainingQuotaChart() {
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Data Type');
        data.addColumn('number', 'Bytes');
	data.addColumn({type: 'string', role: 'tooltip'});
        data.addRows([
	  <?php
		$usedCap = $xml->used->download + $xml->used->upload;
		$remainingCap = getQuota() - $usedCap;
	  ?>
	  ['Remaining Cap', <?= $remainingCap ?>, '<?= formatBytes($remainingCap) ?>'],
	  ['Used Cap', <?= $usedCap ?>, '<?= formatBytes($usedCap) ?>']
        ]);

        // Set chart options
        var options = {'title':'Cap Usage for Current Billing Period',
                       'width':850,
                       'height':350};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('quota_div'));
        chart.draw(data, options);
      }
    </script>

<?php include("foot.inc"); ?>
