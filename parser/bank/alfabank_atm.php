<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class alfabank_atm extends Validator
{
	protected $domain = 'http://alfabank.ru';

	static $urls = [
		'RU-KK'  => [30],
		'RU-TA'  => [24, 14, 26],
		'RU-IRK' => [73, 46, 74],
		'RU-ARK' => [39, 178],
		'RU-KYA' => [723, 78, 49],
		'RU-MOS' => [236, 237, 410, 438, 239, 521, 241, 536, 334],
		'RU-ALT' => [13, 66],
		'RU-BEL' => [40],
		'RU-NVS' => [336, 337, 54],
		'RU-ORE' => [83, 86, 32, 33, 382],
		'RU-PRI' => [1, 69, 70],
		'RU-VLA' => [89],
		'RU-VGG' => [41, 67],
		'RU-VOR' => [43],
		'RU-UD'  => [68, 45],
		'RU-NIZ' => [125, 53],
		'RU-SVE' => [44, 71, 151, 152],
		'RU-MOW' => [235, 21],
		'RU-CHE' => [120, 12, 119, 65],
		'RU-ME'  => [552],
		'RU-KGD' => [47],
		'RU-KLU' => [37],
		'RU-KEM' => [16, 2, 147, 435],
		'RU-KIR' => [31],
		'RU-KHA' => [420, 63],
		'RU-KDA' => [48, 75, 22, 77],
		'RU-KGN' => [50],
		'RU-KRS' => [3],
		'RU-LIP' => [51],
		'RU-KHM' => [87, 5, 88, 8],
		'RU-MUR' => [52],
		'RU-ROS' => [101, 57, 106]
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'atm',
		'ref'             => '',
		'name'            => 'Альфа-Банк',
		'name:ru'         => 'Альфа-Банк',
		'name:en'         => 'Alfa-Bank',
		'official_name'   => '',
		'operator'        => 'АО "Альфа-Банк"', // https://www.cbr.ru/credit/coinfo.asp?id=450000036
		'branch'          => '',
		'contact:website' => 'https://alfabank.ru',
		'contact:phone'   => '+7 495 7888878',
		'currency:RUR'    => 'no',
		'currency:USD'    => 'no',
		'currency:EUR'    => 'no',
		'cash_in'         => 'yes',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand:wikipedia' => 'ru:Альфа-банк',
		'brand:wikidata'  => 'Q1377835'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=atm][operator~"Альфа",i]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$this->log('Обновление данных по региону '.$this->region.'.');

		foreach (static::$urls[$this->region] as $id) {

			$maxcount = 300;
			$offset = 0;
			$count = 30;

			while ($offset < $maxcount) {
				$url = "https://alfabank.ru/ext-json/0.2/atm/list?city=$id&limit=$count&offset=$offset&mode=array&property=own";
				// Только собственные банкоматы!

				$page = $this->get_web_page($url);
				if (is_null($page)) {
					return;
				}

				$maxcount = $this->parse($page);
				$offset+= $count;
			}
		}
	}

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		$maxcount = $a['response']['count'];

		foreach ($a['response']['data'] as $obj) {

			$obj['_addr'] = $obj['address'];
			$obj['ref'] = $obj['pid'];

			// Приём наличных
			if (empty($obj['in'])) {
				$obj['cash_in'] = 'no';
			}

			// Валюты выдачи
			foreach ($obj['out'] as $currency) {
				switch ($currency) {
					case 'rur':
						$obj['currency:RUR'] = 'yes';
						break;
					case 'usd':
						$obj['currency:USD'] = 'yes';
						break;
					case 'eur':
						$obj['currency:EUR'] = 'yes';
						break;
					default:
						$this->log("Parse error! (alfabank_atm: Неизвестный код валюты: '$currency').");
						break;
				}
			}

			// Время работы
			if ($obj['is24'] == 1) {
				$obj['opening_hours'] = '24/7';
			} else {
				$obj['opening_hours'] = $this->time($obj['processing']);
			}

			$this->addObject($this->makeObject($obj));
		}
		return $maxcount;
	}
}
