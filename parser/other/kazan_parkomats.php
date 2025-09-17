<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class kazan_parkomats extends Validator
{
	protected $domain = 'https://parkingkzn.ru/api/2.58/parkomats/?categories=9%2C10%2C21%2C17&lang=ru&fields=_id%2Clocation%2Ccenter%2Ccategory%2Cnumber%2Caddress&active=true&_=1664902859609';

	static $urls = [
		'RU-TA' => ''
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'              => 'vending_machine',
		'vending'              => 'parking_tickets',
		'zone:parking'         => '',
		'ref'                  => '',
		'operator'             => 'Казанский паркинг',
		'contact:website'      => 'https://parkingkzn.ru/ru/',
		'contact:phone'        => '+7 843 2043930',
		'opening_hours'        => '24/7',
		'payment:cash'         => 'no',
		'payment:credit_cards' => 'yes',
		'payment:debit_cards'  => 'yes',
		'lat'                  => '',
		'lon'                  => '',
		'_addr'                => '',
		'brand:wikidata'       => '',
		'brand:wikipedia'      => ''
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[vending=parking_tickets]'
	];

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a['parkomats'] as $obj) {

			// Координаты
			$obj['lat'] = $obj['location']['coordinates'][1];
			$obj['lon'] = $obj['location']['coordinates'][0];

			$obj['ref'] =  $obj['number'];
			$obj['_addr'] = $obj['address']['street'].', '. $obj['address']['house'];

			$this->addObject($this->makeObject($obj));
		}
	}
}
