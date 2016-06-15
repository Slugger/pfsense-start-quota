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
require_once("guiconfig.inc");
require_once('/usr/local/www/widgets/include/start_quota.inc');
?>
<div id="start_quota_container" style="padding: 2px">
	<p><b><i>Loading data...</i></b></p>
</div>
<script>
events.push(
	function() {
		var ajax = $.ajax("/start_quota_ajax.php?seed=<?= time() ?>")
			.done(function(data) {
				$("#start_quota_container").html(data);
			})
			.fail(function() {
				$("#start_quota_container").html("<b>Error loading data!</b>");
			});
	}
);
</script>
