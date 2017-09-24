<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class kenguru extends Validator
{
	protected $domain = 'http://kenguru.ru/info/getshopsformap.php?city_id=';

	static $urls = [
		'RU-IVA' => [1, 34, 19 ,30, 17, 31, 29, 11, 35, 15 ,27],
		'RU-YAR' => [51, 48, 50, 49],
		'RU-VLA' => [38, 41, 40, 44, 43, 39, 37, 45, 57],
		'RU-KOS' => [47, 46, 58],
		'RU-MOS' => [97, 98],
		'RU-MOW' => [52]
	];

	/* Поля объекта */
	protected $fields = [
		'shop'            => 'doityourself',
		'ref'             => '',
		'name'            => 'Кенгуру',
		'name:ru'         => 'Кенгуру',
		'name:en'         => '',
		'operator'        => '',
		'contact:website' => 'http://kenguru.ru',
		'contact:phone'   => '',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'operator:wikidata'        => '',
		'operator:wikipedia'       => ''
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[shop][name~"Кенгуру",i]'
	];

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a['data']['features'] as $obj) {
			$obj['_addr'] = $obj['properties']['balloonContent'];

			$obj['ref'] = $obj['id'];

			$obj['lat'] = $obj['geometry']['coordinates'][0];
			$obj['lon'] = $obj['geometry']['coordinates'][1];

			//$obj['opening_hours'] = $this->time($obj['time']);

			$this->addObject($this->makeObject($obj));
		}
	}
}