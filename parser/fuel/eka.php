<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class eka extends Validator
{
	protected $domain = 'http://www.eka.ru/network_azk/map_azs/ajax/points.php';

	static $urls = [
		'RU-MOS' => '',
		'RU-MOW' => ''
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'fuel',
		'ref'             => '',
		'name'            => 'ЕКА',
		'name:ru'         => 'ЕКА',
		'brand'           => 'ЕКА',
		'operator'        => 'ООО "Топливная компания ЕКА"', // http://www.kartoteka.ru/card/b53293f840ed5eeb184a439e9a693b00/f957c93abfa95c68446e5dfeb07a9315/#path_Main_Card_CardUl_Okved_Egrul
		'contact:website' => 'http://www.eka.ru',
		'contact:phone'   => '',
		'opening_hours'   => '24/7',
		'fuel:octane_98'  => '',
		'fuel:octane_95'  => '',
		'fuel:octane_92'  => '',
		'fuel:octane_80'  => '',
		'fuel:diesel'     => '',
		'fuel:lpg'        => '',
		'fuel:cng'        => '',
		'fuel:discount'   => '',
		'shop'            => '', // отд. точка
		'car_wash'        => '', // отд. точка
		'cafe'            => '', // отд. точка
		'toilets'         => '', // отд. точка
		'compressed_air'  => '', // отд. точка
		'internet_access' => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'wikidata'        => '',
		'wikipedia'       => ''
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=fuel][name~"ЕКА",i]'
	];

	/* Парсер страницы */
	protected function parse($st)
	{
		$st = mb_substr($st, 1);

		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a['fstation'] as $obj) {

			// Координаты
			//$obj['lat'] = $obj['lat'];
			$obj['lon'] = $obj['long'];

			// Отсеиваем по региону
			if (!$this->isInRegionByCoordsFromSputnik($obj['lat'], $obj['lon'])) {
				continue;
			}

			$obj['ref'] = preg_replace("/[^0-9]/", '', $obj['name']);

			// Исключение моек
			if (strripos($obj['name'], 'Мойка') !== false) {
				continue;
			}

			$obj['name'] = 'ЕКА';

			// Адрес
			$obj['_addr'] = $obj['adr'];

			// Контакты
			$obj['contact:phone'] = $this->phone($obj['phone']);

			/* Виды топлива
			$fuels = [
				'АИ-92'  => 'fuel:octane_92', // 1
				'АИ-95'  => 'fuel:octane_95', // 2
				'АИ-98'  => 'fuel:octane_98', // 3
				'ДТ'     => 'fuel:diesel',    // 4
				'АИ-98Е' => 'fuel:octane_98', // 5
				'АИ-95Е' => 'fuel:octane_95', // 6
				'АИ-92Е' => 'fuel:octane_92', // 7
				'ДТ-Евро'=> 'fuel:diesel',    // 8
				'АИ-80'  => 'fuel:octane_80', // 9
				'Газ'    => 'fuel:lpg',       // 10
				'АИ-80'  => 'fuel:octane_80'  // 11
			]; */
			if (isset($a['fuelToItems'][$obj['id']])) {
				foreach ($a['fuelToItems'][$obj['id']] as $fuel) {
					switch ($fuel) {
						case 9: case 11:
							$obj['fuel:octane_80'] = 'yes';
							break;
						case 1: case 7:
							$obj['fuel:octane_92'] = 'yes';
							break;
						case 2: case 6:
							$obj['fuel:octane_95'] = 'yes';
							break;
						case 3: case 5:
							$obj['fuel:octane_95'] = 'yes';
							break;
						case 10:
							$obj['fuel:lpg'] = 'yes';
							break;
						case 4: case 8:
							$obj['fuel:diesel'] = 'yes';
							break;
						default:
							$this->log("Parse error! (eka: Неизвестный вид топлива: '$fuel').");
							break;
					}
				}
			}

			/* Услуги
			$services = [
				'Мойка'           => 'car_wash',        // 1
				'Магазин'         => 'shop',            // 2
				'Кафе'            => 'cafe',            // 3
				'Шиномонтаж'      => '',                // 4
				'Отпуск топлива'  => '',                // 5
				'Отдельное кафе'  => 'cafe',            // 6
				'Супермаркет'     => 'shop',            // 9
				'Прием платежей'  => '',                // 10
				'Пополнение карт' => '',                // 11
				'Онлайн карты'    => '',                // 12
				'Кофе с собой'    => '',                // 13
				'Туалет'          => 'toilets',         // 14
				'Подкачка шин'    => 'compressed_air',  // 15
				'Пылесос'         => '',                // 16
				'McDonald’s'      => 'cafe',            // 17
				'Subway'          => 'cafe',            // 18
				'Бесплатный WiFi' => 'internet_access', // 19
			]; */
			if (isset($a['servicesToItems'][$obj['id']])) {
				foreach ($a['servicesToItems'][$obj['id']] as $service) {
					switch ($service) {
						case 1:
							$obj['car_wash'] = 'yes';
							break;
						case 2: case 9:
							$obj['shop'] = 'yes';
							break;
						case 3: case 6: case 17: case 18:
							$obj['cafe'] = 'yes';
							break;
						case 14:
							$obj['toilets'] = 'yes';
							break;
						case 15:
							$obj['compressed_air'] = 'yes';
							break;
						case 19:
							$obj['internet_access'] = 'wlan';
							break;
						case 4: case 5: case 10: case 11: case 12: case 13: case 16:
							break;
						default:
							$this->log("Parse error! (eka: Неизвестный вид услуги: '$service').");
							break;
					}
				}
			}

			/* Wi-fi
			if ($obj['WiFi'] == 1) {
				$obj['internet_access'] = 'wlan';
			} */

			$this->addObject($this->makeObject($obj));
		}
	}
}