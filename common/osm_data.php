<?php
//#!/usr/bin/php
// ARGUMENTS
// 1 - REGION
// 2 - NAME
// 3 - FILE

if (isset($_SERVER['argv'][3]))
	osm_data($_SERVER['argv'][3], $_SERVER['argv'][1], $_SERVER['argv'][2]);

function osm_data($data, $region, $validator, $type, $timestamp = null)
{
	if (!$data) { // если данные отсутствуют
		return "Данные для ($region | $validator | $type) не были загружены.";
	}

	$count = count($data);

	if (isset($timestamp) && is_string($timestamp)) {
		date_default_timezone_set('UTC');
		$timestamp = strtotime($timestamp);
	} else {
		$timestamp = time();
	}

	$dir = $_SERVER["DOCUMENT_ROOT"].'/data/'.$region;
	if (!file_exists($dir)) mkdir($dir);

	$fname = $dir.'/'.$validator.'_'.$type.'.json';
	$st = ' '.json_encode($data)."\n"; // пробел спереди - чтобы не evalил в ajax

	if (file_exists($fname) && file_get_contents($fname, $st) == $st) { // если содержимое не изменилось
		$msg = "Новые данные для ($region | $validator | $type) отсутствуют.";
	} else { // если есть новые данные
		file_put_contents($fname, $st);
		$msg = "Данные для ($region | $validator | $type) успешно обновлены [$count].";
	}

	// Обновление списка валидаторов
	$fname = $_SERVER["DOCUMENT_ROOT"]."/data/state.js";
	$data = file_get_contents($fname);
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

	return $msg;
}
