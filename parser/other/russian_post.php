<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/common/regions.php';

class russian_post extends Validator
{
	protected $domain = 'https://www.pochta.ru/';

	static $urls = [
		'RU-AD'  => [],
		'RU-AL'  => [],
		'RU-BA'  => [],
		'RU-BU'  => [],
		'RU-DA'  => [],
		'RU-IN'  => [],
		'RU-KB'  => [],
		'RU-KL'  => [],
		'RU-KC'  => [],
		'RU-KR'  => [],
		'RU-KO'  => [],
		'RU-CR'  => [],
		'RU-ME'  => [],
		'RU-MO'  => [],
		'RU-SA'  => [],
		'RU-SE'  => [],
		'RU-TA'  => [],
		'RU-TY'  => [],
		'RU-UD'  => [],
		'RU-KK'  => [],
		'RU-CE'  => [],
		'RU-CU'  => [],
		'RU-ALT' => [],
		'RU-ZAB' => [],
		'RU-KAM' => [],
		'RU-KDA' => [],
		'RU-KYA' => [],
		'RU-PER' => [],
		'RU-PRI' => [],
		'RU-STA' => [],
		'RU-KHA' => [],
		'RU-AMU' => [],
		'RU-ARK' => [],
		'RU-AST' => [],
		'RU-BEL' => [],
		'RU-BRY' => [],
		'RU-VLA' => [],
		'RU-VGG' => [],
		'RU-VLG' => [],
		'RU-VOR' => [],
		'RU-IVA' => [],
		'RU-IRK' => [],
		'RU-KGD' => [],
		'RU-KLU' => [],
		'RU-KEM' => [],
		'RU-KIR' => [],
		'RU-KOS' => [],
		'RU-KGN' => [],
		'RU-KRS' => [],
		'RU-LEN' => [],
		'RU-LIP' => [],
		'RU-MAG' => [],
		'RU-MOS' => [],
		'RU-MUR' => [],
		'RU-NIZ' => [],
		'RU-NGR' => [],
		'RU-NVS' => [],
		'RU-OMS' => [],
		'RU-ORE' => [],
		'RU-ORL' => [],
		'RU-PNZ' => [],
		'RU-PSK' => [],
		'RU-ROS' => [],
		'RU-RYA' => [],
		'RU-SAM' => [],
		'RU-SAR' => [],
		'RU-SAK' => [],
		'RU-SVE' => [],
		'RU-SMO' => [],
		'RU-TAM' => [],
		'RU-TVE' => [],
		'RU-TOM' => [],
		'RU-TUL' => [],
		'RU-TYU' => [],
		'RU-ULY' => [],
		'RU-CHE' => [],
		'RU-YAR' => [],
		'RU-MOW' => [],
		'RU-SPE' => [],
		'RU-SEV' => [],
		'RU-YEV' => [],
		'RU-NEN' => [],
		'RU-KHM' => [],
		'RU-CHU' => [],
		'RU-YAN' => []
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'          => 'post_office',
		'ref'              => '',
		'name'             => '',
		'name:ru'          => '',
		'name:en'          => '',
		'operator'         => 'Почта России',
		'contact:website'  => 'https://www.pochta.ru',
		'contact:facebook' => 'https://www.facebook.com/ruspost',
		'contact:vk'       => 'https://vk.com/russianpost',
		'contact:phone'    => '',
		'opening_hours'    => '',
		'lat'              => '',
		'lon'              => '',
		'_addr'            => '',
		'wikidata'         => 'Q1502763',
		'wikipedia'        => 'ru:Почта_России'
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

		$count = 100;
		$offset = 0;
		$lat = $RU[$this->region]['lat'];
		$lon = $RU[$this->region]['lon'];
		$searchRadius = 1000;

		while (1) {
			$url = "https://www.pochta.ru/portal-portlet/delegate/postoffice-api/method/offices.find.nearby.details?latitude=$lat&longitude=$lon&top=$count&currentDateTime=2016-2-28T2%3A12%3A22&offset=$offset&filter=ALL&hideTemporaryClosed=false&fullAddressOnly=true&searchRadius=$searchRadius";

			$page = $this->get_web_page($url);
			if (is_null($page)) {
				return;
			}

			if ($page == '[]') { // если данные закончились
				break; // заканчиваем поиск
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
		if (is_null($a)) {
			return;
		}

		foreach ($a as $obj) {

			// Координаты
			$obj['lat'] = $obj['latitude'];
			$obj['lon'] = $obj['longitude'];

			// Отсеиваем по региону
			if (!$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
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

			$ref[] = $obj['postalCode']; // сохраняем ref отделения в массив

			$obj['_addr'] = $obj['settlement'].', '.$obj['addressSource'];
			$obj['ref'] = $obj['postalCode'];
			//$obj['name'] = 'Отделение связи №'.$obj['ref'];
			$obj['name'] = $obj['settlement'].' '.$obj['ref'];
			$obj['name:ru'] = $obj['name'];

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

				$time = [];

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
