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
	if (!file_exists($dir))
		mkdir($dir);

	$fname = $dir.'/'.$validator.'_'.$type.'.json';
	$st = ' '.json_encode($data)."\n"; // пробел спереди - чтобы не evalил в ajax

	if (file_exists($fname) && file_get_contents($fname) == $st) { // если содержимое не изменилось
		$msg = "Новые данные для ($region | $validator | $type) отсутствуют.";
	} else { // если есть новые данные
		file_put_contents($fname, $st);
		$msg = "Данные для ($region | $validator | $type) успешно обновлены [$count].";
	}

	// Обновление списка валидаторов
	$fname = $_SERVER["DOCUMENT_ROOT"]."/data/state.json";
	if (file_exists($fname)) {
		$state = file_get_contents($fname);
		$state = json_decode($state, true);
	}

	if (!$state)
		$state = array();

	if (!isset($state["$region.$validator"])) { // если поля не существует
		$state["$region.$validator"] = [$region, $validator, 0, 0, 0]; // создаём
	}

	$state["$region.$validator"][2] = time(); // дата запуска валидатора

	if (strcasecmp($type, 'osm') == 0) { // osm
		$state["$region.$validator"][3] = $timestamp;
	} else { // real
		$state["$region.$validator"][4] = time();
	}

	$state = json_encode($state);

	file_put_contents($fname, $state);

	return $msg;
}