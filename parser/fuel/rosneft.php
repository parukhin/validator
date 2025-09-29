<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class rosneft extends Validator
{
	protected $domain = 'https://rosneft-azs.ru/front-api/stations';

	static $urls = [
		'RU' 	 => '',
		'RU-MOW' => '', // Москва
		'RU-SPE' => '', // Санкт-Петербург
		'RU-AD'  => '', // Республика Адыгея
		'RU-AL'  => '', // Республика Алтай
		'RU-ALT' => '', // Алтайский край
		'RU-ARK' => '', // Архангельская область
		'RU-BEL' => '', // Белгородская область
		'RU-BRY' => '', // Брянская область
		'RU-BU'  => '', // Республика Бурятия
		'RU-VLA' => '', // Владимирская область
		'RU-VGG' => '', // Волгоградская область
		'RU-VOR' => '', // Воронежская область
		'RU-ZAB' => '', // Забайкальский край
		'RU-IVA' => '', // Ивановская область
		'RU-IN'  => '', // Республика Ингушетия
		'RU-IRK' => '', // Иркутская область
		'RU-KB'  => '', // Кабардино-Балкарская Республика
		'RU-KLU' => '', // Калужская область
		'RU-KC'  => '', // Карачаево-Черкесская Республика
		'RU-KR'  => '', // Республика Карелия
		'RU-KEM' => '', // Кемеровская область
		'RU-KOS' => '', // Костромская область
		'RU-KDA' => '', // Краснодарский край
		'RU-KYA' => '', // Красноярский край
		'RU-KGN' => '', // Курганская область
		'RU-KUR' => '', // Курская область
		'RU-LEN' => '', // Ленинградская область
		'RU-LIP' => '', // Липецкая область
		'RU-MO'  => '', // Республика Мордовия
		'RU-MOS' => '', // Московская область
		'RU-MUR' => '', // Мурманская область
		'RU-NIZ' => '', // Нижегородская область
		'RU-NGR' => '', // Новгородская область
		'RU-NVS' => '', // Новосибирская область
		'RU-ORE' => '', // Оренбургская область
		'RU-ORL' => '', // Орловская область
		'RU-PNZ' => '', // Пензенская область
		'RU-PSK' => '', // Псковская область
		'RU-ROS' => '', // Ростовская область
		'RU-RYA' => '', // Рязанская область
		'RU-SAM' => '', // Самарская область
		'RU-SAR' => '', // Саратовская область
		'RU-SVE' => '', // Свердловская область
		'RU-SE'  => '', // Республика Северная Осетия-Алания
		'RU-SMO' => '', // Смоленская область
		'RU-STA' => '', // Ставропольский край
		'RU-TAM' => '', // Тамбовская область
		'RU-TA'  => '', // Республика Татарстан
		'RU-TVE' => '', // Тверская область
		'RU-TOM' => '', // Томская область
		'RU-TUL' => '', // Тульская область
		'RU-TY'  => '', // Республика Тыва
		'RU-UD'  => '', // Удмуртская Республика
		'RU-ULY' => '', // Ульяновская область
		'RU-KK'  => '', // Республика Хакасия
		'RU-KHM' => '', // Ханты-Мансийский автономный округ - Югра
		'RU-CHE' => '', // Челябинская область
		'RU-CE'  => '', // Чеченская республика
		'RU-CU'  => '', // Чувашская Республика
		'RU-YAN' => '', // Ямало-Ненецкий автономный округ
		'RU-YAR' => '' // Ярославская область
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'fuel',
		'name'            => 'Роснефть',
		'name:ru'         => 'Роснефть',
		'brand'           => 'Роснефть',
		'operator'        => '',
		'contact:website' => 'https://rosneft-azs.ru',
		'contact:phone'   => '+7 800 7757588',
		'ref'             => '',
		'opening_hours'   => '24/7', // на всех АЗС сети?
		'fuel:octane_100'  => '',
		'fuel:octane_98'  => '',
		'fuel:octane_95'  => '',
		'fuel:octane_92'  => '',
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
		'[amenity=fuel][name~"Роснефть",i]'
	];

	public function update()
	{
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

		foreach ($st['data']['stations'] as $obj) {
			// Отсеиваем АЗС
			if ($obj['brand'] == 'rosneft') {
				$obj['brand'] = $this->fields['brand'];
			}

			$obj['lat'] = $obj['coordinate']['lat'];
			$obj['lon'] = $obj['coordinate']['lng'];

			// Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			$obj['ref'] = preg_replace("/^АЗС /", '', $obj['number']);

			$obj['_addr'] = $obj['address'];
			$obj['operator'] = $obj['organization'];
			$obj['name'] = '';

            // Виды топлива
				foreach ($obj['fuels'] as $fuel) {
					switch ($fuel['code']) {
						case 'ai92': case 'ai92_atum':
							$obj['fuel:octane_92'] = 'yes';
							break;
						case 'ai95': case 'ai95_atum': case 'ai95_fora':
							$obj['fuel:octane_95'] = 'yes';
							break;
						case 'ai98':
							$obj['fuel:octane_98'] = 'yes';
							break;
						case 'ai100': case 'ai100_fora':
							$obj['fuel:octane_100'] = 'yes';
							break;
						case 'gaz':
							$obj['fuel:lpg'] = 'yes';
							break;
						case 'diesel': case 'diesel_fora':
							$obj['fuel:diesel'] = 'yes';
							break;
						case 'methane':
							$obj['fuel:cng'] = 'yes';
							break;
						default:
							$this->log("Parse error! (rosneft: Неизвестный вид топлива: ".$fuel['code'].").");
							break;
					}
				}

			// /* Услуги */
			foreach ($obj['services'] as $service) {
					switch ($service) {
						case 'cafe':
							$obj['cafe'] = 'yes';
							break;
						case 'wash':
							$obj['car_wash'] = 'yes';
							break;
						case 'shop':
							$obj['shop'] = 'yes';
							break;
					}
				}

			$this->addObject($this->makeObject($obj));
		}
	}
}
