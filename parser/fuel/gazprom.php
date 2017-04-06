<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/common/regions.php';

class gazprom extends Validator
{
	protected $domain = 'https://www.gpnbonus.ru';

	static $urls = [
		'RU-MOW' => ['id' => '136',     'name' => 'Москва%2FМО',           'operator' => 'АО "Газпромнефть-Северо-Запад"'], // eq
		'RU-MOS' => ['id' => '136',     'name' => 'Москва%2FМО',           'operator' => 'АО "Газпромнефть-Северо-Запад"'], // eq
		'RU-SPE' => ['id' => '139',     'name' => 'Санкт-Петербург%2FЛО',  'operator' => 'АО "Газпромнефть-Северо-Запад"'], // eq
		'RU-LEN' => ['id' => '139',     'name' => 'Санкт-Петербург%2FЛО',  'operator' => 'АО "Газпромнефть-Северо-Запад"'], // eq
		'RU-ALT' => ['id' => '233',     'name' => 'Алтайский+край',        'operator' => 'АО "Газпромнефть-Новосибирск"'],
		'RU-VLG' => ['id' => '504900',  'name' => 'Вологодская+область',   'operator' => 'АО "Газпромнефть-Северо-Запад"'],
		'RU-VLA' => ['id' => '375309',  'name' => 'Владимирская+область',  'operator' => 'АО "Газпромнефть-Северо-Запад"'],
		'RU-IVA' => ['id' => '234',     'name' => 'Ивановская+область',    'operator' => 'АО "Газпромнефть-Северо-Запад"'],
		'RU-IRK' => ['id' => '7271989', 'name' => 'Иркутская+область',     'operator' => 'АО "Газпромнефть-Новосибирск"'],
		'RU-KLU' => ['id' => '133',     'name' => 'Калужская+область',     'operator' => 'АО "Газпромнефть-Северо-Запад"'],
		'RU-KEM' => ['id' => '134',     'name' => 'Кемеровская+область',   'operator' => 'АО "Газпромнефть-Новосибирск"'],
		'RU-KIR' => ['id' => '8860028', 'name' => 'Кировская+область',     'operator' => ''], // на сайте не указано
		'RU-KOS' => ['id' => '2929242', 'name' => 'Костромская+область',   'operator' => 'АО "Газпромнефть-Северо-Запад"'],
		'RU-KDA' => ['id' => '1236',    'name' => 'Краснодарский+край',    'operator' => 'АО "Газпромнефть-Новосибирск"'],
		'RU-KYA' => ['id' => '135',     'name' => 'Красноярский+край',     'operator' => 'АО "Газпромнефть-Северо-Запад"'],
		'RU-KGN' => ['id' => '584142',  'name' => 'Курганская+область',    'operator' => 'АО "Газпромнефть-Урал"'],
		'RU-NIZ' => ['id' => '235',     'name' => 'Нижегородская+область', 'operator' => 'АО "Газпромнефть-Северо-Запад"'],
		'RU-NGR' => ['id' => '236',     'name' => 'Новгородская+область',  'operator' => 'АО "Газпромнефть-Северо-Запад"'],
		'RU-NVS' => ['id' => '137',     'name' => 'Новосибирская+область', 'operator' => 'АО "Газпромнефть-Новосибирск"'],
		'RU-OMS' => ['id' => '138',     'name' => 'Омская+область',        'operator' => 'АО "Газпромнефть-Новосибирск"'],
		'RU-PER' => ['id' => '907963',  'name' => 'Пермский+край',         'operator' => 'ООО "Феникс Петролеум"'], // на сайте не указано
		'RU-PNZ' => ['id' => '7840276', 'name' => 'Пензенская+область',    'operator' => ''], // на сайте не указано
		'RU-PSK' => ['id' => '237',     'name' => 'Псковская+область',     'operator' => 'АО "Газпромнефть-Северо-Запад"'],
		'RU-KR'  => ['id' => '34014',   'name' => 'Республика+Карелия',    'operator' => 'АО "Газпромнефть-Северо-Запад"'],
		'RU-KK'  => ['id' => '6752639', 'name' => 'Республика+Хакасия',    'operator' => 'АО "Газпромнефть-Новосибирск"'],
		'RU-RYA' => ['id' => '34013',   'name' => 'Рязанская+область',     'operator' => 'АО "Газпромнефть-Северо-Запад"'],
		'RU-SAM' => ['id' => '4389479', 'name' => 'Самарская+область',     'operator' => ''], // на сайте не указано
		'RU-SVE' => ['id' => '132',     'name' => 'Свердловская+область',  'operator' => 'АО "Газпромнефть-Урал"'],
		'RU-SMO' => ['id' => '140',     'name' => 'Смоленская+область',    'operator' => 'АО "Газпромнефть-Северо-Запад"'],
		'RU-TVE' => ['id' => '141',     'name' => 'Тверская+область',      'operator' => 'АО "Газпромнефть-Северо-Запад"'],
		'RU-TUL' => ['id' => '9588076', 'name' => 'Тульскую+область',      'operator' => ''], // на сайте не указано
		'RU-TOM' => ['id' => '142',     'name' => 'Томская+область',       'operator' => 'АО "Газпромнефть-Новосибирск"'],
		'RU-TYU' => ['id' => '143',     'name' => 'Тюменская+область',     'operator' => 'АО "Газпромнефть-Урал"'],
		'RU-KHM' => ['id' => '584143',  'name' => 'ХМАО+-+Югра',           'operator' => 'АО "Газпромнефть-Урал"'],
		'RU-CHE' => ['id' => '144',     'name' => 'Челябинская+область',   'operator' => 'АО "Газпромнефть-Урал"'],
		'RU-YAN' => ['id' => '588981',  'name' => 'Ямало-Ненецкий+АО',     'operator' => 'АО "Газпромнефть-Урал"'],
		'RU-YAR' => ['id' => '145',     'name' => 'Ярославская+область',   'operator' => 'АО "Газпромнефть-Северо-Запад"']
		//'' => ['id' => '', 'name' => '', '' => ''],
		// http://www.spb.gazprom-neft.ru/about/ - АО "Газпромнефть-Северо-Запад"
		// http://eburg.gazprom-neft.ru/about/ - АО "Газпромнефть-Урал"
		// http://www.nsk.gazprom-neft.ru/about/ - АО "Газпромнефть-Новосибирск"
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
		'owner'           => 'ПАО "Газпром нефть"',
		'contact:website' => 'http://www.gazprom-neft.ru',
		'contact:phone'   => '',
		'opening_hours'   => '',
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
		'wikidata'        => '',
		'wikipedia'       => 'ru:Газпром нефть'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=fuel][name~"Газпром",i]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$this->log('Обновление данных по региону '.$this->region.'.');

		global $RU;

		$id = static::$urls[$this->region]['id'];
		$name = static::$urls[$this->region]['name'];
		$lat = $RU[$this->region]['lat'];
		$lon = $RU[$this->region]['lon'];

		$url = $this->domain.'/our_azs/?region_id='.$id.'&region_name='.$name.'&CenterLon='.$lon.'&CenterLat='.$lat.'&city=';

		$page = $this->get_web_page($url);
		if (is_null($page)) {
			return;
		}
		$this->parse($page, $id);
	}

	/* Парсер страницы */
	protected function parse($st, $id)
	{
		// сохраняем параметры заправок
		$this->ext = [];

		if (preg_match_all('#'
			.'АЗС №(?<ref>\d+)'
			//.'azs_number_(?<ref>\d+)'
			.'.+?<nobr>(?<text>.+?serviceText.+?)<'
			.'#s', $st, $m, PREG_SET_ORDER))
		foreach ($m as $item) {
			$a = [];
			/* Виды топлива */
			if (mb_strpos($item['text'], '>98<'))  $a['fuel:octane_98'] = 'yes';
			if (mb_strpos($item['text'], '>95<'))  $a['fuel:octane_95'] = 'yes';
			if (mb_strpos($item['text'], '>92<'))  $a['fuel:octane_92'] = 'yes';
			if (mb_strpos($item['text'], '>80<'))  $a['fuel:octane_80'] = 'yes';
			if (mb_strpos($item['text'], '>ДТ<'))  $a['fuel:diesel']    = 'yes';
			if (mb_strpos($item['text'], '>ГАЗ<')) $a['fuel:lpg']       = 'yes';
			if (mb_strpos($item['text'], '>КПГ<')) $a['fuel:cng']       = 'yes';

			/* Услуги */
			if (mb_strpos($item['text'], 'Пути'))     $a['fuel:discount']  = 'Нам по пути';
			if (mb_strpos($item['text'], 'руглосут')) $a['opening_hours']  = '24/7';
			if (mb_strpos($item['text'], 'Магаз'))    $a['shop']           = 'yes';
			if (mb_strpos($item['text'], 'мойка'))    $a['car_wash']       = 'yes';
			if (mb_strpos($item['text'], 'Кафе'))     $a['cafe']           = 'yes';
			if (mb_strpos($item['text'], 'Туал'))     $a['toilets']        = 'yes';
			if (mb_strpos($item['text'], 'Подкачка')) $a['compressed_air'] = 'yes';

			$this->ext[$item['ref']] = $a;
		}

		// ищем все заправки
		if (preg_match_all('#'
			.'GeoPoint.(?<lon>[\d\.]+),(?<lat>[\d\.]+)'
			.'.+?№(?<ref>\d+)'
			.'.+?>(?<_addr>.+?)"'
			.'#s', $st, $m, PREG_SET_ORDER))
		foreach ($m as $obj) {
			$obj['operator'] = static::$urls[$this->region]['operator'];
			// фильтруем заправки не нашего региона
			if ($id == 136)
			if (!$this->isInRegion('Москва|Зеленогр', 'RU-MOW', $obj['_addr'])) continue;
			if ($id == 139)
			if (!$this->isInRegion('Петербург',       'RU-SPE', $obj['_addr'])) continue;

			if (isset($this->ext[$obj['ref']]))
				$obj += $this->ext[$obj['ref']];
			$this->addObject($this->makeObject($obj));
		}
	}
}
