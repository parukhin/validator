<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class bashneft extends Validator
{
	protected $domain = 'https://www.bashneft-azs.ru';

	static $urls = [
		'RU-VLA' => ['id' => '239'],
		'RU-KGN' => ['id' => '235'],
		'RU-NIZ' => ['id' => '240'],
		'RU-ORE' => ['id' => '246'],
		'RU-BA'  => ['id' => '210'],
		'RU-MO'  => ['id' => '232'],
		'RU-TA'  => ['id' => '227'],
		'RU-SAM' => ['id' => '228'],
		'RU-SAR' => ['id' => '245'],
		'RU-SVE' => ['id' => '238'],
		'RU-SMO' => ['id' => '248'],
		'RU-UD'  => ['id' => '225'],
		'RU-ULY' => ['id' => '233'],
		'RU-CHE' => ['id' => '237'],
		'RU-CU'  => ['id' => '236']
		//'' => ['id' => ''],
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'fuel',
		'name'            => 'Башнефть',
		'name:ru'         => 'Башнефть',
		'brand'           => 'Башнефть',
		'operator'        => '',
		'contact:website' => 'https://www.bashneft-azs.ru',
		'contact:phone'   => '+7 800 7757588',
		'ref'             => '',
		'opening_hours'   => '',
		'fuel:octane_100'  => '',
		'fuel:octane_98'  => '',
		'fuel:octane_95'  => '',
		'fuel:octane_92'  => '',
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
		'brand:wikipedia' => 'ru:Башнефть'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=fuel][name~"Башнефть",i]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$id = static::$urls[$this->region]['id'];
		$url = $this->domain.'/include_areas/new_azs_filter_2018.php?region_azs='.$id;

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

		foreach ($st['points'] as $obj) {
			$obj['lat'] = $obj['x'];
			$obj['lon'] = $obj['y'];

			if (mb_strpos($obj['caption'], 'Партнер')) {
				if (!preg_match('#'
				.'.?№\s*(?<ref>[\dА-Я/-]+)'
				.'.+?(?<operator>(Партнер )?О[ОА]О .+»)'
				.'.+?address">(?<_addr>.+?)<'
				."#su", $obj['header'], $m)) continue;
				$obj['operator'] = str_replace(['«','»'], "", $m['operator']);
			} else {
				if (!preg_match('#'
				.'.?№\s*(?<ref>[\dА-Я/-]+)'
				.'.+?address">(?<_addr>.+?)<'
				."#su", $obj['header'], $m)) continue;
				$obj['operator'] = 'ООО "Башнефть-Розница"';
			}

			$obj['ref'] = $m['ref'];
			$obj['_addr'] = $m['_addr'];

			/* Виды топлива */
			$obj['fuel:octane_100'] = mb_strpos($obj['body'], '>100<')  ? 'yes' : '';
			$obj['fuel:octane_98'] = mb_strpos($obj['body'], '>98<')  ? 'yes' : '';
			$obj['fuel:octane_95'] = (mb_strpos($obj['body'], '>ATUM-95 Евро 6<') || mb_strpos($obj['body'], '>ATUM-95<') || mb_strpos($obj['body'], '>95<'))  ? 'yes' : '';
			$obj['fuel:octane_92'] = (mb_strpos($obj['body'], '>92<') || mb_strpos($obj['body'], '>ATUM-92<'))  ? 'yes' : '';
			$obj['fuel:lpg']       = mb_strpos($obj['body'], '>Газ<') ? 'yes' : '';
			$obj['fuel:diesel']    = mb_strpos($obj['body'], '>ДТ<')  ? 'yes' : '';

			/* Услуги */
			$obj['fuel:discount']  = mb_strpos($obj['body'], 'Дисконтные карты')      ? 'Башнефть' : '';
			$obj['opening_hours']  = mb_strpos($obj['body'], 'Круглосуточная работа') ? '24/7'     : '';
			$obj['toilets']        = mb_strpos($obj['body'], 'Туалет')                ? 'yes'      : ''; // указывать отдельной точкой amenity=toilets
			$obj['shop']           = mb_strpos($obj['body'], 'Магазин')               ? 'yes'      : ''; // указывать отдельной точкой shop=convenience или shop=kiosk
			$obj['car_wash']       = mb_strpos($obj['body'], 'Мойка')                 ? 'yes'      : ''; // указывать отдельной точкой amenity=car_wash
			$obj['cafe']           = mb_strpos($obj['body'], 'Кафе')                  ? 'yes'      : ''; // указывать отдельной точкой amenity=cafe
			// Программа лояльности
			// Дисконтные карты
			// Спецпредложения/акции
			// Автоматические АЗС
			// Терминал оплаты услуг
			// Банкомат

			/* Способы оплаты */
			$obj['payment:visa']       = mb_strpos($obj['body'], 'Карта VISA')       ? 'yes' : '';
			$obj['payment:mastercard'] = mb_strpos($obj['body'], 'Карта MasterCard') ? 'yes' : '';
			// Топливная карта (payment:fuel_cards = yes)
			// Карта лояльности

			// TODO: обработать все виды
			// FIXME: учесть время технического перерыва, уточнить корректность использования тегов (payment:fuel_cards = yes, payment:cards=yes)

			$this->addObject($this->makeObject($obj));
		}
	}
}
