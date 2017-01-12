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
if (!$files)
{
	echo "Unknown validator".$validator;
	return;
}
//Код валидатора, например parser\bank\alfabank.php
require_once $files[0];

$region = '';
if (isset($_POST['region']))
	$region = $_POST['region']; //MOW-RU
if (!$region)
	$region= $_GET['region']; //MOW-RU

if ($region == '')
{
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
foreach ($regions as $region)
{
	if ($validator::isRegion($region))
		validate($region);
}

function validate($region)
{
	global $validator;

	$v = new $validator($region);

	$v->useCacheHtml = !empty($GLOBALS['html-cache']);
	$v->updateHtml   = !empty($GLOBALS['update']);

	//Загружаем данные из ОСМ
	$v->loadOSM();
	//Загружаем данные со страницы парсера
	$v->update();
	//$v->validate();

	// временно сохраняем в старом формате
	require_once './osm_data.php';
	$objects = $v->getOSMObjects();
	array_push($objects, $v->getNewestTimestamp());
	$msg = osm_data($objects, $region, $validator, 'osm');
	$v->log($msg);
	$msg = osm_data($v->getObjects(), $region, $validator, 'real');
	$v->log($msg);
}
