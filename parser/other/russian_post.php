<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class russian_post extends Validator
{
	protected $domain = 'https://www.pochta.ru/';

	static $urls = [
		'RU-ARK' => [
			'region' => 'Архангельская обл',
			'count' => 1400,
		],
		'RU-BRY' => [
			'region' => 'Брянская обл',
			'count' => 1400,
		],
		'RU-BEL' => [
			'region' => 'Белгородская обл',
			'count' => 1400,
		],
		'RU-CU' => [
			'region' => 'Чувашская Республика - Чувашия',
			'count' => 700,
		],
		'RU-KDA' => [
			'region' => 'Краснодарский край',
			'count' => 2000,
		],
		'RU-KEM' => [
			'region' => 'Кемеровская обл',
			'count' => 1600,
		],
		'RU-KHA'=> [
			'region' => 'Хабаровский край',
			'count' => 1280,
		],
		'RU-KHM'=> [
			'region' => 'Ханты-Мансийский Автономный округ - Югра АО',
			'count' => 1000,
		],
		'RU-KGD' => [
			'region' => 'Калининградская обл',
			'count' => 300,
		],
		'RU-KIR' => [
			'region' => 'Кировская обл',
			'count' => 1792,
		],
		'RU-KYA' => [
			'region' => 'Красноярский край',
			'count' => 6000,
		],
		'RU-LIP' => [
			'region' => 'Липецкая обл',
			'count' => 1280,
		],
		'RU-LEN' => [
			'region' => 'Ленинградская обл',
			'count' => 1300,
		],
		'RU-MOS' => [
			'region' => 'Московская обл',
			'count' => 5000,
		],
		'RU-MOW' => [
			'region' => 'Москва г',
			'count' => 1000,
		],
		'RU-MUR' => [
			'region' => 'Мурманская обл',
			'count' => 256,
		],
		'RU-RYA' => [
			'region' => 'Рязанская обл',
			'count' => 1000,
		],
		'RU-TVE' => [
			'region' => 'Тверская обл',
			'count' => 2000,
		],
		'RU-ROS' => [
			'region' => 'Ростовская обл',
			'count' => 3000,
		],
		'RU-SPE' => [
			'region' => 'Санкт-Петербург г',
			'count' => 400,
		],
		'RU-AD' => [
			'region' => 'Адыгея Респ',
			'count' => 600,
		],
		'RU-TA' => [
			'region' => 'Татарстан Респ',
			'count' => 2700,
		],
		'RU-PNZ' => [
			'region' => 'Пензенская обл',
			'count' => 1300,
		],
		'RU-BA' => [
			'region' => 'Башкортостан Респ' ,
			'count' => 2500,
		],
		'RU-CHE' => [
			'region' => 'Челябинская обл',
			'count' => 1500,
		],
		'RU-VLA' => [
			'region' => 'Владимирская обл',
			'count' => 1100,
		],
		'RU-PER' => [
			'region' => 'Пермский край',
			'count' => 1664,
		],
		'RU-NVS' => [
			'region' => 'Новосибирская обл',
			'count' => 1300,
		],
		'RU-OMS' => [
			'region' => 'Омская обл',
			'count' => 1000,
		],
		'RU-IRK' => [
			'region' => 'Иркутская обл',
			'count' => 1300,
		],
		'RU-PRI' => [
			'region' => 'Приморский край',
			'count' => 1664,
		],
		'RU-ULY' => [
			'region' => 'Ульяновская обл',
			'count' => 1200,
		],
		'RU-VGG' => [
			'region' => 'Волгоградская обл',
			'count' => 1500,
		],
		'RU-VLG' => [
			'region' => 'Вологодская обл',
			'count' => 5000,
		],
		'RU-VOR' => [
			'region' => 'Воронежская обл',
			'count' => 2000,
		],
		'RU-IVA' => [
			'region' => 'Ивановская обл',
			'count' => 2000,
		],
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'post_office',
		'ref'             => '',
		'name'            => '',
		'operator'        => 'Почта России',
		'contact:website' => 'https://www.pochta.ru',
		'contact:phone'   => '',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=post_office]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$this->log('Update real data '.$this->region);

		global $RU;

		$maxcount = 4000;
		if (isset(static::$urls[$this->region]['count'])) {
			$maxcount = static::$urls[$this->region]['count'];
		}

		$count = 64;
		$offset = 0;
		$lat = $RU[$this->region]['lat'];
		$lon = $RU[$this->region]['lon'];

		$url = "https://www.pochta.ru/portal-portlet/delegate/postoffice-api/method/offices.find.nearby.details?latitude=$lat&longitude=$lon&top=$count&currentDateTime=2016-2-28T2%3A12%3A22&filter=ALL&hideTemporaryClosed=false&fullAddressOnly=true&searchRadius=10000&offset=$offset";

		while($offset < $maxcount)
		{
			$page = $this->get_web_page($url);
			if (is_null($page)) {
				return;
			}

			$this->parse($page);
			$offset+= $count;
		}
	}

	/* Парсер страницы */
	protected function parse($st)
	{
		static $ref = [];

		$a = json_decode($st, true);
		if (!isset($a)) {
			return;
		}

		foreach ($a as $obj)
		{
			// Если вылезли в соседние регионы
			if ($obj['region'] != static::$urls[$this->region]['region']) {
				continue;
			}

			// Исключение передвижных отделений из поиска (typeId = 18, typeCode = 'ПОПС')
			if ($obj['typeId'] == 18) {
				continue;
			}

			// typeCode = 'СОПС', typeId = 9 - сельское отделение почтовой связи
			// typeCode = 'ГОПС', typeId = 8 - городское отделение почтовой связи
			// typeCode = 'ПОПС', typeId = 18 - передвижное отделение почтовой связи

			// Исключение повторений по ref
			if (in_array($obj['postalCode'], $ref)) {
				continue;
			}

			array_push($ref, $obj['postalCode']); // сохраняем ref отделения в массив

			$obj['_addr'] = $obj['settlement'].', '.$obj['addressSource'];
			$obj['ref'] = $obj['postalCode'];
			//$obj['name'] = 'Отделение связи №'.$obj['ref'];
			$obj['name'] = $obj['settlement'].' '.$obj['ref'];
			$obj['lat'] = $obj['latitude'];
			$obj['lon'] = $obj['longitude'];

			foreach ($obj['phones'] as $ph) {
				if (!isset($obj['contact:phone']))
					$obj['contact:phone'] = '';
				else
					$obj['contact:phone'] .= '; ';
				$obj['contact:phone'] .= '+7 '.((isset($ph['phoneTownCode']))?($ph['phoneTownCode'].' '):'').$ph['phoneNumber'];
			}

			/* Режим работы */
			if (isset($obj['workingHours'])) {

				$wd = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];

				$time = '';

				foreach ($obj['workingHours'] as $day => $wh) {
					if (isset($wh['beginWorkTime'])) { // рабочий день
						if (isset($wh['lunches']) && (count($wh['lunches']) > 0)) { // есть обеденный перерыв
							$time[$wd[$wh['weekDayId'] - 1]] = substr($wh['beginWorkTime'], 0,5).'-'.substr($wh['lunches'][0]['beginLunchTime'], 0,5).',';
							$time[$wd[$wh['weekDayId'] - 1]] .= substr($wh['lunches'][0]['endLunchTime'], 0,5).'-'.substr($wh['endWorkTime'], 0,5);
						} else { // без перерыва
							$time[$wd[$wh['weekDayId'] - 1]] = substr($wh['beginWorkTime'], 0,5).'-'.substr($wh['endWorkTime'], 0,5);
						}
					}
				}
				$obj['opening_hours'] = $this->time($time);
			}
			$this->addObject($this->makeObject($obj));
		}
	}
}
