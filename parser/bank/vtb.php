<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class vtb extends Validator
{
	protected $domain = 'https://h.vtb.ru/projects/atm/models/default/items/departments';

	static $urls = [
		'RU'     => '',
		'RU-BA'  => '',
		'RU-CU'  => '',
		'RU-ME'  => '',
		'RU-TA'  => '',
		'RU-NIZ' => '',
		'RU-MOW' => '',
		'RU-MOS' => '',
		'RU-LEN' => '',
		'RU-SPE' => '',
		'RU-ULY' => ''
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'bank',
		'ref'             => '',
		'name'            => 'ВТБ',
		'name:ru'         => 'ВТБ',
		'name:en'         => 'VTB',
		'official_name'   => '',
		'operator'        => 'Банк ВТБ (публичное акционерное общество)', // https://www.cbr.ru/banking_sector/credit/coinfo/?id=350000008
		'branch'          => '',
		'contact:website' => 'https://www.vtb.ru',
		'contact:phone'   => '+7 800 1002424',
		'wheelchair'      => '',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand'           => 'ВТБ',
		'brand:wikidata'  => 'Q1549389'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=bank][name~"ВТБ",i]'
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
		foreach ($st['branches'] as $obj) {
			// Координаты
			$obj['lat'] = $obj['coordinates']['latitude'];
			$obj['lon'] = $obj['coordinates']['longitude'];

			// Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			// Идентификатор
			$obj['ref'] = $obj['Biskvit_id'];

			// Адрес
			$obj['_addr'] = $obj['address'];

			$obj['official_name'] = str_replace(['«','»', ], '"', $obj['shortName']);

			// if (preg_match('/"(.+?)"/', $obj['official_name'], $m)) {
			// 	$obj['branch'] = $m[1];
			// }

			// Доступность для инвалидных колясок
			if (!is_null($obj['special']['ramp'])) { $obj['wheelchair'] = ($obj['special']['ramp'] == '1') ? 'yes' : 'no';
			};

			// Время работы
			if (is_null($obj['scheduleFl'])) {
				$a = array(
					"Mo" => $obj['scheduleJurL'][1],
					"Tu" => $obj['scheduleJurL'][2],
					"We" => $obj['scheduleJurL'][3],
					"Th" => $obj['scheduleJurL'][4],
					"Fr" => $obj['scheduleJurL'][5],
					"Sa" => $obj['scheduleJurL'][6],
					"Su" => $obj['scheduleJurL'][7]
				);
				foreach (array_keys($a, 'выходной', true) as $key) {
					unset($a[$key]);
				}
				$obj['opening_hours'] = $this->time($a);
			} else {
				$a = array(
					"Mo" => $obj['scheduleFl'][1],
					"Tu" => $obj['scheduleFl'][2],
					"We" => $obj['scheduleFl'][3],
					"Th" => $obj['scheduleFl'][4],
					"Fr" => $obj['scheduleFl'][5],
					"Sa" => $obj['scheduleFl'][6],
					"Su" => $obj['scheduleFl'][7]
				);
				foreach (array_keys($a, 'выходной', true) as $key) {
					unset($a[$key]);
				}
				$obj['opening_hours'] = $this->time($a);
			}



			$this->addObject($this->makeObject($obj));
		}
	}
}
