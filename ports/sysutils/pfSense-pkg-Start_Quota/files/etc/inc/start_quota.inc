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

function getXmlData() {
	$xmlFile = '/tmp/startquota.xml';
	if(file_exists($xmlFile) && time() - getDataDate() < 3600)
		return file_get_contents($xmlFile);
	else {
		$xmlData = file_get_contents('http://www.start.ca/support/usage/api?key=' . getApiKey()); 
		if($xmlData !== false && $xmlData != 'ERROR')
			file_put_contents($xmlFile, $xmlData);
		return $xmlData;
	}
}

function getDataDate() {
	return filemtime('/tmp/startquota.xml');
}

function isConfigured() {
	global $config;
	$pluginConfig = $config['installedpackages']['startquota']['config'][0];
	return !empty($pluginConfig['startapikey']) && $pluginConfig['startquota'] != ''; 
}

function getApiKey() {
	global $config;
	return $config['installedpackages']['startquota']['config'][0]['startapikey'];
}

function getQuota() {
	global $config;
	return 1000000000 * $config['installedpackages']['startquota']['config'][0]['startquota'];
}

function formatBytes($size, $precision = 2) {
    if($size == 0) return '0 B';
    $base = log(0 + $size, 1000);
    $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1000, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}
?>
