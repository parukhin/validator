<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/common/regions.php';

class alfabank extends Validator
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
		'amenity'         => 'bank',
		'ref'             => '',
		'name'            => 'Альфа-Банк',
		'name:ru'         => 'Альфа-Банк',
		'name:en'         => 'Alfa-Bank',
		'official_name'   => '',
		'operator'        => 'АО "Альфа-Банк"', // https://www.cbr.ru/credit/coinfo.asp?id=450000036
		'branch'          => '',
		'contact:website' => 'https://alfabank.ru',
		'contact:phone'   => '+7 495 7888878',
		'opening_hours'   => '',
		'wheelchair'      => '', // disabled
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'operator:wikipedia'       => 'ru:Альфа-банк',
		'operator:wikidata'        => 'Q1377835'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=bank][name~"Альфа",i]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		/* Обновление id городов
		global $RU;

		$url = 'https://alfabank.ru/ext-json/0.2/office/city?limit=500&mode=array';

		$page = $this->get_web_page($url);
		if (is_null($page)) {
			return;
		}

		$a = json_decode($page, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a['response']['data'] as $item) {
			$ref = '';
			$code = $item['region'];

			foreach ($RU as $key => $region) {
				if ($region['code'] == $code) {
					$ref = $key;
					continue;
				}
			}
			if ($ref == '') { // если регион так и остался пустым
				$this->log('Регион с кодом '.$region['code'].' не найден!');
				continue;
			}

			$regions[$ref][] = $item['id'];
		}
		*/

		$this->log('Обновление данных по региону '.$this->region.'.');

		foreach (static::$urls[$this->region] as $id) {

			$maxcount = 300;
			$offset = 0;
			$count = 30;

			while ($offset < $maxcount) {

				$url = "https://alfabank.ru/ext-json/0.2/office/list?city=$id&limit=$count&offset=$offset&mode=array&kind=retail";
				// для людей с ограниченными возможностями добавить &services=disabled
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

			$obj['official_name'] = str_replace('"', '', $obj['title']);
			$obj['_addr'] = $obj['address'];
			$obj['ref'] = $obj['pid'];

			// Время работы
			$str = html_entity_decode($obj['processing']['retail']);
			$str = str_replace(["!--", "\n"], "", $str);
			if (preg_match('/.+?<br ?\/><br? ?\/?>/su', $str, $m)) {
				$obj['opening_hours'] = $this->time($m[0]);
			} else {
				$obj['opening_hours'] = $this->time($str);
			}

			$this->addObject($this->makeObject($obj));
		}
		return $maxcount;
	}
}
