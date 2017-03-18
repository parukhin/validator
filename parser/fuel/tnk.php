<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class tnk extends Validator
{
	protected $domain = 'https://komandacard.ru/home/getgasstations';

	static $urls = [
		'RU' => [] // пока для всей страны
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'fuel',
		'name'            => '',
		'name:ru'         => '',
		'brand'           => 'ТНК',
		'operator'        => '',
		'contact:website' => 'http://www.tnk.ru',
		'contact:phone'   => '',
		'ref'             => '',
		'opening_hours'   => '24/7', // на всех АЗС сети?
		'fuel:octane_98'  => '',
		'fuel:octane_95'  => '',
		'fuel:octane_92'  => '',
		'fuel:octane_80'  => '',
		'fuel:diesel'     => '',
		'fuel:lpg'        => '',
		'fuel:cng'        => '',
		'fuel:discount'   => 'Семейная команда', // на всех АЗС сети?
		'shop'            => '', // отд. точка
		'car_wash'        => '', // отд. точка
		'cafe'            => '', // отд. точка
		'toilets'         => '', // отд. точка
		'compressed_air'  => '', // отд. точка
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=fuel][name~"ТНК",i]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$this->log('Обновление данных по региону '.$this->region.'.');

		$url = $this->domain;

		$page = $this->get_web_page($url);
		if (is_null($page)) {
			return;
		}
		$this->parse($page);
	}

	/* Парсер страницы */
	protected function parse($st)
	{
		$st = json_decode($st, true);
		if (is_null($st)) {
			return;
		}

		foreach ($st as $obj) {
			// Отсеиваем АЗС Роснефти
			if ($obj['owner'] != '2') {
				continue;
			}

			$obj['lat'] = $obj['location'][0];
			$obj['lon'] = $obj['location'][1];
			$obj['_addr'] = $obj['description'];
			$obj['name:ru'] = $obj['name'];

			/* Виды топлива */
			if (in_array('1',  $obj['stationServiceTypes'])) $obj['fuel:diesel'] = 'yes';
			if (in_array('3',  $obj['stationServiceTypes'])) $obj['fuel:lpg'] = 'yes';
			if (in_array('5',  $obj['stationServiceTypes'])) $obj['fuel:octane_92'] = 'yes';
			if (in_array('6',  $obj['stationServiceTypes'])) $obj['fuel:octane_95'] = 'yes';
			if (in_array('7',  $obj['stationServiceTypes'])) $obj['fuel:octane_98'] = 'yes';

			/* Услуги */
			if (in_array('9',  $obj['stationServiceTypes'])) $obj['shop'] = 'yes';
			if (in_array('10', $obj['stationServiceTypes'])) $obj['car_wash'] = 'yes';
			if (in_array('11', $obj['stationServiceTypes'])) $obj['cafe'] = 'yes';
			//if (in_array('13', $obj['stationServiceTypes'])) $obj['amenity'] = '?'; // шиномонтаж

			$this->addObject($this->makeObject($obj));
		}
	}
}
