<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class lapy4 extends Validator
{
	protected $domain = 'https://4lapy.ru';

	static $urls = [
		'RU-MOW' => '9839',
		'RU-MOS' => '9591',
		'RU-VLA' => '9587',
		'RU-VGG' => '9654',
		'RU-VOR' => '9723',
		'RU-IVA' => '9588',
		'RU-KLU' => '9589',
		'RU-KOS' => '9683',
		'RU-LIP' => '9590',
		'RU-NIZ' => '9836',
		'RU-TUL' => '9691',
		'RU-ORL' => '9991',
		'RU-RYA' => '9592',
		'RU-TVE' => '9722',
		'RU-YAR' => '9593',
		'RU'     => ''
	];

	/* Поля объекта */
	protected $fields = [
		'shop'            => 'pet',
		'name'            => 'Четыре лапы',
		'name:ru'         => 'Четыре лапы',
		'name:en'         => '',
		'contact:website' => 'https://4lapy.ru',
		'contact:phone'   => '',
		'opening_hours'   => '',
		'pets'            => '',
		'aquarium'        => '',
		'veterinary'      => '',
		'grooming'        => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[shop=pet][name~"лапы",i]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$this->log('Update real data '.$this->region);

		$id = static::$urls[$this->region];

		$url = "https://4lapy.ru/ajax/ajax.php";
		$query = "operation=get-list-shop-on-map&filter-region=$id&filter-city=";

		$page = $this->get_web_page($url, $query);
		if (is_null($page)) {
			return;
		}

		$this->parse($page);
	}

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a['shops'] as $obj) {
			$obj['name'] = 'Четыре лапы';

			// Координаты
			$obj['lat'] = $obj['gps']['longitude']; // на сайте перепутано
			$obj['lon'] = $obj['gps']['latitude'];

			// Адрес
			$obj['_addr'] = $obj['address'];

			// Время работы
			$obj['opening_hours'] = $this->time($obj['workTime']);

			// Сервисы
			foreach ($obj['services'] as $service) {
				switch ($service['cssClass']) {
					case 'aquarium':
						$obj['aquarium'] = 'yes';
						break;
					case 'pharmacy':
						$obj['veterinary'] = 'yes';
						break;
					case 'animals':
						$obj['pets'] = 'yes';
						break;
					case 'gravirovka':
						//$obj['?'] = 'yes';
						break;
					case 'grooming':
						$obj['grooming'] = 'yes';
						break;
				}
			}

			// Телефон
			$obj['contact:phone'] = $this->phone($obj['phone']);

			$this->addObject($this->makeObject($obj));
		}
	}
}
