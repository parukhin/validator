<?php
require_once 'Validator.class.php';

class rosneft extends Validator
{
	protected $domain = 'https://komandacard.ru/home/getgasstations';

	static $urls = [
		'RU-MOW' => ['Moscow-Region/Moscow' => '/Downstream/petroleum_product_sales/servicestations/$1/'],
		'RU-MOS' => ['Moscow-Region/Region' => '/Downstream/petroleum_product_sales/servicestations/$1/'],
		'RU-SPE' => ['St_Petersburg'        => '/Downstream/petroleum_product_sales/servicestations/$1/'],
		'RU-LEN' => ['Leningrad_Region'     => '/Downstream/petroleum_product_sales/servicestations/$1/'],
		'RU-VOR' => ['Voronezh_Region'      => '/Downstream/petroleum_product_sales/servicestations/$1/'],
		'RU-KDA' => ['Krasnodar_Territory'  => '/Downstream/petroleum_product_sales/servicestations/$1/'],
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'fuel',
		'name'            => '',
		'name:ru'         => '',
		'brand'           => 'Роснефть',
		'operator'        => 'ОАО Роснефть',
		'contact:website' => 'http://www.rosneft-azs.ru',
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
		'shop'            => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=fuel][name~"[Рр]оснефть"]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$this->log('Update real data '.$this->region);

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
			// Отсеиваем АЗС ТНК-BP
			if ($obj['owner'] != '1') {
				continue;
			}
			$obj['lat'] = $obj['location'][0];
			$obj['lon'] = $obj['location'][1];
			$obj['_addr'] = $obj['description'];
			$obj['name:ru'] = $obj['name'];

			if (in_array('1',  $obj['stationServiceTypes'])) $obj['fuel:diesel'] = 'yes';
			if (in_array('3',  $obj['stationServiceTypes'])) $obj['fuel:lpg'] = 'yes';
			if (in_array('5',  $obj['stationServiceTypes'])) $obj['fuel:octane_92'] = 'yes';
			if (in_array('6',  $obj['stationServiceTypes'])) $obj['fuel:octane_95'] = 'yes';
			if (in_array('7',  $obj['stationServiceTypes'])) $obj['fuel:octane_98'] = 'yes';
			if (in_array('9',  $obj['stationServiceTypes'])) $obj['shop'] = 'convenience'; // магазин
			//if (in_array('13', $obj['stationServiceTypes'])) $obj['amenity'] = ''; // шиномонтаж
			//if (in_array('10', $obj['stationServiceTypes'])) $obj['amenity'] = 'car_wash'; // мойка
			//if (in_array('11', $obj['stationServiceTypes'])) $obj['amenity'] = 'cafe'; // кафе

			$this->addObject($this->makeObject($obj));
		}
	}
}
