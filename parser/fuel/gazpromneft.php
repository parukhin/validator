<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/common/regions.php';

class gazpromneft extends Validator
{
	protected $domain = 'https://gpnbonus.ru/api/stations/list';

	static $urls = [
		'RU-MOW' => ['id' => '136',     'name' => 'Москва%2FМО',           'operator' => 'ООО "Газпромнефть - Центр"'], // eq
		'RU-MOS' => ['id' => '136',     'name' => 'Москва%2FМО',           'operator' => 'ООО "Газпромнефть - Центр"'], // eq
		'RU-SPE' => ['id' => '139',     'name' => 'Санкт-Петербург%2FЛО',  'operator' => 'ООО "Газпромнефть - Центр"'], // eq
		'RU-LEN' => ['id' => '139',     'name' => 'Санкт-Петербург%2FЛО',  'operator' => 'ООО "Газпромнефть - Центр"'], // eq
		'RU-ALT' => ['id' => '233',     'name' => 'Алтайский+край',        'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-VLG' => ['id' => '504900',  'name' => 'Вологодская+область',   'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-VLA' => ['id' => '375309',  'name' => 'Владимирская+область',  'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-IVA' => ['id' => '234',     'name' => 'Ивановская+область',    'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-IRK' => ['id' => '7271989', 'name' => 'Иркутская+область',     'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-KLU' => ['id' => '133',     'name' => 'Калужская+область',     'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-KEM' => ['id' => '134',     'name' => 'Кемеровская+область',   'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-KIR' => ['id' => '8860028', 'name' => 'Кировская+область',     'operator' => ''], // на сайте не указано
		'RU-KOS' => ['id' => '2929242', 'name' => 'Костромская+область',   'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-KDA' => ['id' => '1236',    'name' => 'Краснодарский+край',    'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-KYA' => ['id' => '135',     'name' => 'Красноярский+край',     'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-KGN' => ['id' => '584142',  'name' => 'Курганская+область',    'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-NIZ' => ['id' => '235',     'name' => 'Нижегородская+область', 'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-NGR' => ['id' => '236',     'name' => 'Новгородская+область',  'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-NVS' => ['id' => '137',     'name' => 'Новосибирская+область', 'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-OMS' => ['id' => '138',     'name' => 'Омская+область',        'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-PER' => ['id' => '907963',  'name' => 'Пермский+край',         'operator' => 'ООО "Феникс Петролеум"'], // на сайте не указано
		'RU-PNZ' => ['id' => '7840276', 'name' => 'Пензенская+область',    'operator' => ''], // на сайте не указано
		'RU-PSK' => ['id' => '237',     'name' => 'Псковская+область',     'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-KR'  => ['id' => '34014',   'name' => 'Республика+Карелия',    'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-KK'  => ['id' => '6752639', 'name' => 'Республика+Хакасия',    'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-RYA' => ['id' => '34013',   'name' => 'Рязанская+область',     'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-SAM' => ['id' => '4389479', 'name' => 'Самарская+область',     'operator' => ''], // на сайте не указано
		'RU-SVE' => ['id' => '132',     'name' => 'Свердловская+область',  'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-SMO' => ['id' => '140',     'name' => 'Смоленская+область',    'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-TVE' => ['id' => '141',     'name' => 'Тверская+область',      'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-TUL' => ['id' => '9588076', 'name' => 'Тульскую+область',      'operator' => ''], // на сайте не указано
		'RU-TOM' => ['id' => '142',     'name' => 'Томская+область',       'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-TYU' => ['id' => '143',     'name' => 'Тюменская+область',     'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-KHM' => ['id' => '584143',  'name' => 'ХМАО+-+Югра',           'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-CHE' => ['id' => '144',     'name' => 'Челябинская+область',   'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-YAN' => ['id' => '588981',  'name' => 'Ямало-Ненецкий+АО',     'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-YAR' => ['id' => '145',     'name' => 'Ярославская+область',   'operator' => 'ООО "Газпромнефть - Центр"'],
		'RU-TA'  => ['id' => '',        'name' => 'Республика+Татарстан',  'operator' => 'ООО "Газпромнефть - Центр"']
		//'' => ['id' => '', 'name' => '', '' => ''],
		// Предыдущие АО присоединены к ООО "Газпромнефть - Центр"
		// FIXME: уточнить отсутсвующие!
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'fuel',
		'ref'             => '',
		'name'            => 'Газпромнефть',
		'name:ru'         => 'Газпромнефть',
		'name:en'         => 'Gazpromneft',
		'brand'           => 'Газпромнефть',
		'operator'        => '',
		'contact:website' => 'https://gpnbonus.ru/',
		'contact:phone'   => '+7 800 7005151',
		'opening_hours'   => '24/7',
		'fuel:octane_100' => '',
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
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand:wikidata'  => '',
		'brand:wikipedia' => 'ru:Газпром нефть'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=fuel][name~"Газпром",i]'
	];

	/* Обновление данных по региону */
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

			foreach ($st['stations'] as $obj) {
				// Отсеиваем АЗС Опти
				if ($obj['brand_id'] != '31') {
					continue;
				}

				$obj['lat'] = $obj['latitude'];
				$obj['lon'] = $obj['longitude'];

				// Отсеиваем по региону
				if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
					continue;
				}

				$obj['_addr'] = $obj['city'].' '.$obj['address'];
				$obj['ref'] = str_replace('АЗС №','',$obj['name']);
				$obj['name'] = $obj['name:ru'];

				$obj['operator'] = static::$urls[$this->region]['operator'];

				/* Виды топлива */
				foreach ($obj['oils'] as $fuel) {
					switch ($fuel) {
						case '62':
							$obj['fuel:octane_92'] = 'yes';
							break;
						case '12':
							$obj['fuel:octane_95'] = 'yes';
							break;
						case '421':
							$obj['fuel:octane_95'] = 'yes';
							break;
						case '7':
							$obj['fuel:octane_98'] = 'yes';
							break;
						case '100032':
							$obj['fuel:octane_100'] = 'yes';
							break;
						case '373':
							$obj['fuel:lpg'] = 'yes';
							break;
						case '372':
							$obj['fuel:diesel'] = 'yes';
							break;
						case '424':
							$obj['fuel:diesel'] = 'yes';
							break;
						case '531':
							$obj['fuel:cng'] = 'yes';
							break;
						default:
						$fuel_id=$fuel['id'];
							$this->log("Parse error! (gazpromneft: Неизвестный вид топлива: '$fuel_id').");
							break;
					}
				}

				/* Услуги */
				if (in_array('shop',  $obj['services']['person'])) $obj['shop'] = 'yes';
				if ($obj['wash']) $obj['car_wash'] = 'yes';
				if (in_array('cafe', $obj['services']['person'])) $obj['cafe'] = 'yes';
				//if (in_array('13', $obj['stationServiceTypes'])) $obj['amenity'] = '?'; // шиномонтаж

				$this->addObject($this->makeObject($obj));
			}
		}
}
