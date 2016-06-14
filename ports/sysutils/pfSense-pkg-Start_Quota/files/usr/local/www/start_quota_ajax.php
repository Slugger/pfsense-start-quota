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
require_once('start_quota.inc');
require_once('/usr/local/www/widgets/include/start_quota.inc');
$xml = new SimpleXMLElement(getXmlData());
?>
	<table width="100%" id="start_quota_widget" summary="Start.ca Usage">
		<tbody>
			<tr>
				<th>Type</th>
				<th>Download</th>
				<th>Upload</th>
				<th>Total</th>
			</tr>
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
			<?php
				if(getQuota() > 0)
					echo '<tr><td colspan="4"><b>Quota Remaining: ' . formatBytes(getQuota() - $xml->used->download - $xml->used->upload) . '</b></td></tr>';
				echo '<tr><td colspan="4"><i>Data current as of ' . date('D, j M Y G:i T', getDataDate()) . '</i></td></tr>';
			?>
		</tbody>
	</table>
