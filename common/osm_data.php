<?php
//#!/usr/bin/php
// ARGUMENTS
// 1 - REGION
// 2 - NAME
// 3 - FILE

if (isset($_SERVER['argv'][3]))
	osm_data($_SERVER['argv'][3], $_SERVER['argv'][1], $_SERVER['argv'][2]);

function osm_data($data, $region, $validator, $type)
{
	if (is_string($data)) {
		$data = @unserialize(@file_get_contents($data));
	}

	if (!$data) { // если данные отсутствуют
		echo "Empty data! ".(is_string($data)?$data:$region)."\n";
		return;
	}

	$msg = 'OK';

	$count = count($data);

	$timestamp = time();
	if (is_string($data[count($data)-1]))
	{
		$timestamp = array_pop($data);
		date_default_timezone_set('UTC');
		$timestamp = strtotime($timestamp);
	}

	$dir = $_SERVER["DOCUMENT_ROOT"]."/data/".$region;
	if (!file_exists($dir)) mkdir($dir);

	$fname = $dir.'/'.$validator.'_'.$type.'.json';
	$st = ' '.json_encode($data)."\n"; // пробел спереди - чтобы не evalил в ajax
	//сохряняем буквы
	file_put_contents($fname, $st);

	//// сжимаем
	//$st = gzencode($st);
	////TODO Зачем забивать пустотой?
	////file_put_contents($fname, ''); // нужно для nginx на отладочном сервере
	//$fname .= ".gz";
	// сохраняем данные
	//if (!file_exists($dir)) mkdir($dir);

	// выходим, если содержимое не изменилось
	if (file_exists($fname) && file_get_contents($fname, $st) == $st)
		$msg = "SKIP";
	//else
	//{
	//	file_put_contents($fname, $st);
	//	chmod($fname, 0666);
	//}

	// обновляем список валидаторов
	$fname = $_SERVER["DOCUMENT_ROOT"]."/data/state.js";
	$data = @file_get_contents($fname);
	$data = substr($data, 2, -1);

	$data = json_decode($data, true);
	if (!$data) $data = array();

	if (!isset($data["$region.$validator"])) { // если поля не существует
		$data["$region.$validator"] = [$region, $validator, 0, 0, 0]; // создаём
	}

	$data["$region.$validator"][2] = time(); // дата запуска валидатора

	if (strcasecmp($type, 'osm') == 0) { // osm
		$data["$region.$validator"][3] = $timestamp;
	} else { // real
		$data["$region.$validator"][4] = time();
	}

	$data = json_encode($data);

	$data = "_($data)";
	file_put_contents($fname, $data);

	return "Make JSON ".$region."/".$validator."_".$type." [".$count." objects] ".$msg;
}
