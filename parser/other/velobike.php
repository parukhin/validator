<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class velobike extends Validator
{
	protected $domain = 'https://apivelobike.velobike.ru/ride/parkings';

	static $urls = [
		'RU-MOW' => ''
	];

	/* Поля объекта */
	protected $fields = [
		'network'         => 'Велобайк',
		'amenity'         => 'bicycle_rental',
		'capacity'        => '',
		'contact:email'   => 'info@velobike.ru',
		'contact:phone'   => '+7 495 9568286',
		'contact:website' => 'https://velobike.ru',
		'operator'        => 'ЗАО "СитиБайк"',
		'ref'             => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
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
			$obj['_addr'] = $obj['Name'];

			$obj['ref'] = (int)$obj['Id'];
			$obj['capacity'] = $obj['TotalPlaces'];

			$obj['lat'] = $obj['Position']['Lat'];
			$obj['lon'] = $obj['Position']['Lon'];

			$this->addObject($this->makeObject($obj));
		}
	}
}
