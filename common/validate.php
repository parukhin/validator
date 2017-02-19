<?php
//Вызываем http://host/common/validate.php?validator=blood&region=RU-SPE
//Дата в логе у УТЦ
date_default_timezone_set('UTC');

header('Content-type: text/plain; charset=utf-8');

$validator = '';
if (isset($_POST['validator']))
	$validator = $_POST['validator']; //alfabank

if (!$validator && isset($_GET['validator']))
	$validator= $_GET['validator']; //alfabank

if ($validator == "")
	echo "Unknown validator ".$validator;

//echo $validator;

//надо найти фаел с таким именем...
$files = glob($_SERVER["DOCUMENT_ROOT"]."/parser/*/$validator.php");
if (!$files) {
	echo "Unknown validator".$validator;
	return;
}

//Код валидатора, например parser\bank\alfabank.php
require_once $files[0];

$region = '';
if (isset($_POST['region']))
	$region = $_POST['region'];
if (!$region)
	$region= $_GET['region'];

if ($region == '') {
	echo "Unknown region".$region;
	return;
}

//$st = implode('', $_SERVER['argv']);
//if (preg_match_all('#--([a-z-]+)#', $st, $m))
//	foreach ($m[1] as $p) $GLOBALS[$p] = true;

//if (empty($GLOBALS['no-cache']))
//	$GLOBALS['html-cache'] = true;

if (!$region) // регион не указан - обрабатываем все
	$regions = $validator::getRegions();
else
	$regions = explode(',', $region); // можно передать список, разделенный запятой

// запускаем каждую область
foreach ($regions as $region) {
	if ($validator::isRegion($region)) {
		validate($region);
	}
}

function validate($region)
{
	global $validator;

	$v = new $validator($region);

	$v->useCacheHtml = !empty($GLOBALS['html-cache']);
	$v->updateHtml   = !empty($GLOBALS['update']);

	// Обновление данных из базы OSM
	$v->update_osm();
	// Обновление данных по региону
	$v->update();

	// временно сохраняем в старом формате
	require_once $_SERVER["DOCUMENT_ROOT"].'/common/osm_data.php';

	$msg = osm_data($v->get_objects_osm(), $region, $validator, 'osm', $v->get_timestamp());
	$v->log($msg);

	$msg = osm_data($v->get_objects_real(), $region, $validator, 'real');
	$v->log($msg);
}
