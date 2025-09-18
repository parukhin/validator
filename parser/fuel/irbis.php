<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class irbis extends Validator
{
	protected $domain = 'https://smartapi.azsirbis.ru/web/stations';

	static $urls = [
		'RU-BA' => '',
		'RU-ME' => '',
		'RU-NIZ'  => '',
		'RU-SAM'  => '',
		'RU-TA'  => '',
		'RU-VLA' => '',
		'RU' => ''
		//'' => ['id' => ''],
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'          => 'fuel',
		'ref'              => '',
		'name'             => 'Irbis',
		'name:ru'          => 'Ирбис',
		'brand'            => 'IRBIS',
		'operator'         => '',
		'contact:website'  => 'https://smart.azsirbis.ru',
		'contact:phone'    => '+7 800 5005330',
		'contact:telegram' => 'https://t.me/AZS_IRBIS_client',
		'contact:vk'       => 'https://vk.com/azsirbis',
		'opening_hours'    => '',
		'fuel:octane_98'   => '',
		'fuel:octane_95'   => '',
		'fuel:octane_92'   => '',
		'fuel:diesel'      => '',
		'fuel:lpg'         => '',
		'fuel:adblue'      => '',
		'internet_access'  => '',
		'atm'              => '', // отд. точка
		'shop'             => '', // отд. точка
		'car_wash'         => '', // отд. точка
		'toilets'          => '', // отд. точка
		'cafe'             => '', // отд. точка
		'compressed_air'   => '', // отд. точка
		'fast_food'        => '', // отд. точка
		'lat'              => '',
		'lon'              => '',
		'_addr'            => ''
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=fuel][name~"Irbis",i]'
	];

	/* Парсер страницы */
	protected function parse($st)
	{
		$st = json_decode($st, true);
		if (is_null($st)) {
			return;
		}

		foreach ($st as $obj) {
			$obj['lat'] = $obj['latitude'];
			$obj['lon'] = $obj['longitude'];

            // Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			$obj['_addr'] = $obj['address'];

            /* Виды топлива
			$fuels = [
				'АИ-92'     => 'fuel:octane_92',
				'АИ-92 Xtrim' => 'fuel:octane_92',
				'АИ-95'     => 'fuel:octane_95',
				'АИ-95 Xtrim'     => 'fuel:octane_95',
				'АИ-98'     => 'fuel:octane_98',
				'АИ-100'     => 'fuel:octane_100',
				'ГАЗ'          => 'fuel:lpg',
				'ДТ'       => 'fuel:diesel',
				'ДТ Xtrim'       => 'fuel:diesel'
			]; */
				foreach ($obj['Services'] as $service) {
					switch ($service['display_name']) {
						case 'АИ-92': case 'АИ-92 Xtrim':
							$obj['fuel:octane_92'] = 'yes';
							break;
						case 'АИ-95': case 'АИ-95 Xtrim':
							$obj['fuel:octane_95'] = 'yes';
							break;
						case 'АИ-98':
							$obj['fuel:octane_98'] = 'yes';
							break;
						case 'АИ-100':
							$obj['fuel:octane_100'] = 'yes';
							break;
						case 'ГАЗ':
							$obj['fuel:lpg'] = 'yes';
							break;
						case 'ДТ': case 'ДТ Xtrim':
							$obj['fuel:diesel'] = 'yes';
							break;
						case 'AdBlue':
							$obj['fuel:adblue'] = 'yes';
							break;
						case '24 часа':
							$obj['opening_hours'] = '24/7';
							break;
						case 'Банкомат':
							$obj['atm'] = 'yes';
							break;
						case 'Туалет':
							$obj['toilets'] = 'yes';
							break;
						case 'Кафе':
							$obj['cafe'] = 'yes';
							break;
						case 'Шаурма':
							$obj['fast_food'] = 'yes';
							break;
						case 'Магазин':
							$obj['shop'] = 'yes';
							break;
						case 'Подкачка шин':
							$obj['compressed_air'] = 'yes';
							break;
						case 'Автомойка':
							$obj['car_wash'] = 'yes';
							break;
						case 'Wi-Fi':
							$obj['internet_access'] = 'wlan';
							break;
						case 'Продукция халяль': case 'Мягкое мороженое': case 'Молельная комната': 
						case 'Зарядка электромобилей': case 'Парковка': case 'Душ': case 'Прачечная':
						case 'Шиномонтаж': case 'Отель':
							break;
						default:
							$this->log("Parse error! (irbis: Неизвестный сервис: " . $service['display_name']);
							break;
					}
				}

			$this->addObject($this->makeObject($obj));
		}
	}
}
