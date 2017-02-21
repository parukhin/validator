<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class velobike extends Validator
{
	protected $domain = 'http://velobike.ru';

	static $urls = [
		'RU-MOW' => '/proxy/parkings',
	];

	/* Поля объекта */
	protected $fields = [
		'network'           => 'Велобайк',
		'amenity'           => 'bicycle_rental',
		'capacity'          => '',
		'contact:email'     => 'info@velobike.ru',
		'contact:phone'     => '+7 495 9568286',
		'contact:website'   => 'http://velobike.ru',
		'operator'          => 'ЗАО "СитиБайк"',
		'ref'               => '',
		'lat'               => '',
		'lon'               => '',
		'_addr'             => '',
		];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=bicycle_rental][network="Велобайк"]'
	];

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a['Items'] as $obj) {
			$obj['_addr'] = substr($obj['Address'], 6);

			$obj['ref'] = sprintf("%d", $obj['Id']);
			$obj['capacity'] = $obj['TotalPlaces'];

			$obj['lat'] = $obj['Position']['Lat'];
			$obj['lon'] = $obj['Position']['Lon'];

			$this->addObject($this->makeObject($obj));
		}
	}
}
