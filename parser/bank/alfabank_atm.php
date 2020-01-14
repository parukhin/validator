<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class alfabank_atm extends Validator
{
	protected $domain = 'https://alfabank.ru';

	static $urls = [
		'RU-TUL' => [4],
		'RU-ALT' => [13, 66],
		'RU-ARK' => [39, 178],
		'RU-BA'  => [139, 38],
		'RU-BEL' => [40],
		'RU-VLA' => [89],
		'RU-VGG' => [41, 67],
		'RU-VOR' => [43],
		'RU-IRK' => [73, 46, 74],
		'RU-KGD' => [47],
		'RU-KLU' => [37],
		'RU-KR'  => [34],
		'RU-KEM' => [16, 2, 147, 435],
		'RU-KIR' => [31],
		'RU-KDA' => [48, 75, 22, 77],
		'RU-KYA' => [723, 78, 49],
		'RU-KGN' => [50],
		'RU-KRS' => [3],
		'RU-LIP' => [51],
		'RU-ME'  => [552],
		'RU-MO'  => [417],
		'RU-MOS' => [236, 237, 241, 460, 410, 239, 536, 438, 521, 334],
		'RU-MOW' => [21, 235],
		'RU-MUR' => [52],
		'RU-NIZ' => [125, 53],
		'RU-NVS' => [336, 337, 54],
		'RU-OMS' => [55],
		'RU-ORE' => [83, 86, 32, 33, 382],
		'RU-PNZ' => [11],
		'RU-PER' => [56],
		'RU-PRI' => [1, 69, 70],
		'RU-PSK' => [25],
		'RU-ROS' => [101, 57, 106],
		'RU-RYA' => [9],
		'RU-SAM' => [58, 296, 6],
		'RU-SPE' => [18],
		'RU-LEN' => [129],
		'RU-SAR' => [28, 100],
		'RU-SA'  => [36],
		'RU-SAK' => [15],
		'RU-SVE' => [44, 71, 151, 152],
		'RU-STA' => [60],
		'RU-TA'  => [24, 14, 26],
		'RU-TVE' => [92],
		'RU-TOM' => [61],
		'RU-TYU' => [62],
		'RU-UD'  => [68, 45],
		'RU-ULY' => [23],
		'RU-KHA' => [420, 63],
		'RU-KK'  => [30],
		'RU-KHM' => [87, 5, 88, 8],
		'RU-CHE' => [120, 12, 119, 65],
		'RU-CU'  => [64],
		'RU-YAR' => [17]
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'atm',
		'ref'             => '',
		'name'            => 'Альфа-Банк',
		'name:ru'         => 'Альфа-Банк',
		'name:en'         => 'Alfa-Bank',
		//'official_name'   => '',
		'operator'        => 'АО "Альфа-Банк"', // https://www.cbr.ru/credit/coinfo.asp?id=450000036
		'branch'          => '',
		'contact:website' => 'https://alfabank.ru',
		'contact:phone'   => '+7 495 7888878',
		'currency:RUB'    => 'no',
		'currency:USD'    => 'no',
		'currency:EUR'    => 'no',
		'cash_in'         => 'no',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand'           => 'Альфа-Банк',
		'brand:ru'        => 'Альфа-Банк',
		'brand:en'        => 'Alfa-Bank',
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
		foreach (static::$urls[$this->region] as $id) {

			$maxcount = 1000;
			$offset = 0;
			$count = 1000;

			while ($offset < $maxcount) {
				$url = "https://alfabank.ru/ext-json/0.2/atm/list?city=$id&limit=$count&offset=$offset&mode=array&property=own";
				// Только собственные банкоматы!

				$page = $this->get_web_page($url);
				if (is_null($page)) {
					return;
				}

				$this->parse($page);
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

			// Валюты (выдача)
			foreach ($obj['out'] as $currency) {
				switch ($currency) {
					case 'rur':
						$obj['currency:RUB'] = 'yes';
						break;
					case 'rub':
						$obj['currency:RUB'] = 'yes';
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

			// Приём наличных
			if (!empty($obj['in'])) {
				$obj['cash_in'] = 'yes';
			}

			// Время работы
			if ($obj['is24'] == 1) {
				$obj['opening_hours'] = '24/7';
			} else {
				$obj['opening_hours'] = $this->time($obj['processing']);
			}

			$this->addObject($this->makeObject($obj));
		}
	}
}
