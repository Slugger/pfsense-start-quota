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

$pgtitle = array(gettext("Start.ca"), gettext("Quota"));
include("head.inc");
$tabs = array();
$tabs[] = array(gettext("Settings"), false, "/pkg_edit.php?xml=start-quota.xml&id=0");
display_top_tabs($tabs);
session_start();
$e = $_SESSION['START_QUOTA_ERROR'] 
?>

<div class="panel panel-default">
	<div class="panel-heading"><h2 class="panel-title">ERROR</h2></div>
	<div class="panel-body">
		There was an error fetching the quota data from the Start 
		Communications servers.  Check the package settings and ensure
		the API key is correct.  If an exception was provided then it
		will be displayed below.
	</div>
	<div id="exception"><pre>
<?php if($e != NULL) echo $e; ?>	
	</pre></div>
</div>

<?php include("foot.inc"); ?>
