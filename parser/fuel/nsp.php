<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class nsp extends Validator
{
	protected $domain = 'https://nonstoppower.ru/wp-content/themes/NSP/assets/php/testmap.php';

	static $urls = [
		'RU-TA'  => ''
		//'' => ['id' => ''],
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'charging_station',
		'ref'             => '',
		'name'            => 'NSP',
		'name:ru'         => '',
		'brand'           => 'Non-Stop Power',
		'operator'        => '',
		'contact:website' => 'https://nonstoppower.ru/',
		'contact:phone'   => '+7 800 5000296', 
		'opening_hours'   => '24/7',
		'fuel:octane_98'  => '',
		'fuel:octane_95'  => '',
		'fuel:octane_92'  => '',
		'fuel:diesel'     => '',
		'fuel:lpg'        => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => ''
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=charging_station]' // [name~"NSP",i]
	];

	/* Парсер страницы */
	protected function parse($st)
	{
		$st = json_decode($st, true);
		if (is_null($st)) {
			return;
		}

		foreach ($st['features'] as $obj) {
			$obj['lat'] = $obj['latitude'];
			$obj['lon'] = $obj['longitude'];
            $obj['_addr'] = $obj['address'];

            // Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			// ref АЗС из fuelShortcode
			$obj['ref'] = $obj['id'];


            /* Виды топлива
			$fuels = [
				'АИ-92-К5' => 'fuel:octane_92',
				'АИ-95-К5' => 'fuel:octane_95',
				'АИ-98-К5' => 'fuel:octane_98',
				'газ'      => 'fuel:lpg',
				'дизель'   => 'fuel:diesel'
			]; */
				foreach ($obj['fuelType'] as $fuel) {
					switch ($fuel) {
						case 'АИ-92-К5':
							$obj['fuel:octane_92'] = 'yes';
							break;
						case 'АИ-95-К5':
							$obj['fuel:octane_95'] = 'yes';
							break;
						case 'АИ-98-К5':
							$obj['fuel:octane_98'] = 'yes';
							break;
						case 'газ':
							$obj['fuel:lpg'] = 'yes';
							break;
						case 'дизель':
							$obj['fuel:diesel'] = 'yes';
							break;
						default:
							$this->log("Parse error! (taifnk: Неизвестный вид топлива: '$fuel').");
							break;
					}
				}

			$this->addObject($this->makeObject($obj));
		}
	}
}
