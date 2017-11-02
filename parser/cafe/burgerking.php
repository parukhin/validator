<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class burgerking extends Validator
{
	protected $domain = 'https://burgerking.ru/restaurant-locations-json-reply-new';

	static $urls = [
		'RU' => '',
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'             => 'fast_food',
		'ref'                 => '',
		'name'                => 'Бургер Кинг',
		'name:ru'             => 'Бургер Кинг',
		'name:en'             => 'Burger King',
		'operator'            => 'ООО "БУРГЕР РУС"',
		'cuisine'             => 'burger',
		'diet:vegetarian'     => 'no',
		'drive_through'       => '',
		'brand'               => 'Бургер Кинг',
		'contact:website'     => 'https://burgerking.ru',
		'contact:phone'       => '',
		'contact:email'       => '',
		'contact:facebook'    => 'https://www.facebook.com/BurgerKingRussia',
		'wheelchair'          => '',
		'opening_hours'       => '',
		'internet_access'     => '',
		'internet_access:fee' => '',
		'lat'                 => '',
		'lon'                 => '',
		'_addr'               => '',
		'brand:wikipedia'     => 'ru:Burger King',
		'brand:wikidata'      => 'Q177054'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=fast_food][name~"Бургер Кинг",i]'
	];

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (!isset($a)) {
			return;
		}

		foreach ($a as $obj) {
			//$obj['lat'] = $obj['lat'];
			$obj['lon'] = $obj['lng'];

			// Отсеиваем по региону
			if (!$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			$obj['name'] = 'Бургер Кинг';

			$obj['_addr'] = $obj['address'];

			$obj['ref'] = $obj['origID'];

			$obj['contact:phone'] = $this->phone($obj['tel']);
			$obj['contact:email'] = $obj['email'];

			// Режим работы
			if ($obj['is_24'] == '1') {
				$obj['opening_hours'] = '24/7';
			} else {
				$obj['opening_hours'] = $this->time($obj['opened']);
			}

			$this->addObject($this->makeObject($obj));
		}
	}
}
