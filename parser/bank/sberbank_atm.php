<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/common/regions.php';

class sberbank_atm extends Validator
{
	protected $domain = 'http://www.sberbank.ru';

	static $urls = [
		// Байкальский банк
		'RU-ZAB' => ['branch' => 'Байкальский банк'],
		'RU-IRK' => ['branch' => 'Байкальский банк'],
		'RU-BU'  => ['branch' => 'Байкальский банк'],
		'RU-SA'  => ['branch' => 'Байкальский банк'],

		// Волго-Вятский банк
		'RU-NIZ' => ['branch' => 'Волго-Вятский банк'],
		'RU-VLA' => ['branch' => 'Волго-Вятский банк'],
		'RU-KIR' => ['branch' => 'Волго-Вятский банк'],
		'RU-MO'  => ['branch' => 'Волго-Вятский банк'],
		'RU-ME'  => ['branch' => 'Волго-Вятский банк'],
		'RU-CU'  => ['branch' => 'Волго-Вятский банк'],
		'RU-TA'  => ['branch' => 'Волго-Вятский банк'],

		// Дальневосточный банк
		'RU-KHA' => ['branch' => 'Дальневосточный банк'],
		'RU-PRI' => ['branch' => 'Дальневосточный банк'],
		'RU-AMU' => ['branch' => 'Дальневосточный банк'],
		'RU-SAK' => ['branch' => 'Дальневосточный банк'],
		'RU-YEV' => ['branch' => 'Дальневосточный банк'],
		'RU-MAG' => ['branch' => 'Дальневосточный банк'],
		'RU-KAM' => ['branch' => 'Дальневосточный банк'],
		'RU-CHU' => ['branch' => 'Дальневосточный банк'],

		// Западно-Сибирский банк
		'RU-TYU' => ['branch' => 'Западно-Сибирский банк'],
		'RU-OMS' => ['branch' => 'Западно-Сибирский банк'],
		'RU-KHM' => ['branch' => 'Западно-Сибирский банк'],
		'RU-YAN' => ['branch' => 'Западно-Сибирский банк'],

		// Западно-Уральский банк
		'RU-PER' => ['branch' => 'Западно-Уральский банк'],
		'RU-KO'  => ['branch' => 'Западно-Уральский банк'],
		'RU-UD'  => ['branch' => 'Западно-Уральский банк'],

		// Московский банк
		'RU-MOW' => ['branch' => 'Московский банк'],

		// Поволжский банк
		'RU-SAM' => ['branch' => 'Поволжский банк'],
		'RU-ULY' => ['branch' => 'Поволжский банк'],
		'RU-ORE' => ['branch' => 'Поволжский банк'],
		'RU-SAR' => ['branch' => 'Поволжский банк'],
		'RU-VGG' => ['branch' => 'Поволжский банк'],
		'RU-AST' => ['branch' => 'Поволжский банк'],
		'RU-PNZ' => ['branch' => 'Поволжский банк'],

		// Северный банк
		'RU-YAR' => ['branch' => 'Северный банк'],
		'RU-KOS' => ['branch' => 'Северный банк'],
		'RU-IVA' => ['branch' => 'Северный банк'],
		'RU-VLG' => ['branch' => 'Северный банк'],
		'RU-NEN' => ['branch' => 'Северный банк'],
		'RU-ARK' => ['branch' => 'Северный банк'],

		// Северо-Западный банк
		'RU-SPE' => ['branch' => 'Северо-Западный банк'],
		'RU-LEN' => ['branch' => 'Северо-Западный банк'],
		'RU-MUR' => ['branch' => 'Северо-Западный банк'],
		'RU-KGD' => ['branch' => 'Северо-Западный банк'],
		'RU-PSK' => ['branch' => 'Северо-Западный банк'],
		'RU-NGR' => ['branch' => 'Северо-Западный банк'],
		'RU-KR'  => ['branch' => 'Северо-Западный банк'],

		// Сибирский банк
		'RU-NVS' => ['branch' => 'Сибирский банк'],
		'RU-TOM' => ['branch' => 'Сибирский банк'],
		'RU-KEM' => ['branch' => 'Сибирский банк'],
		'RU-ALT' => ['branch' => 'Сибирский банк'],
		'RU-AL'  => ['branch' => 'Сибирский банк'],
		'RU-KYA' => ['branch' => 'Сибирский банк'],
		'RU-TY'  => ['branch' => 'Сибирский банк'],
		'RU-KK'  => ['branch' => 'Сибирский банк'],

		// Среднерусский банк
		'RU-MOS' => ['branch' => 'Среднерусский банк'],
		'RU-TVE' => ['branch' => 'Среднерусский банк'],
		'RU-KLU' => ['branch' => 'Среднерусский банк'],
		'RU-BRY' => ['branch' => 'Среднерусский банк'],
		'RU-SMO' => ['branch' => 'Среднерусский банк'],
		'RU-TUL' => ['branch' => 'Среднерусский банк'],
		'RU-RYA' => ['branch' => 'Среднерусский банк'],

		// Уральский банк
		'RU-SVE' => ['branch' => 'Уральский банк'],
		'RU-CHE' => ['branch' => 'Уральский банк'],
		'RU-KGN' => ['branch' => 'Уральский банк'],
		'RU-BA'  => ['branch' => 'Уральский банк'],

		// Центрально-Черноземный банк
		'RU-VOR' => ['branch' => 'Центрально-Черноземный банк'],
		'RU-ORL' => ['branch' => 'Центрально-Черноземный банк'],
		'RU-LIP' => ['branch' => 'Центрально-Черноземный банк'],
		'RU-KRS' => ['branch' => 'Центрально-Черноземный банк'],
		'RU-BEL' => ['branch' => 'Центрально-Черноземный банк'],
		'RU-TAM' => ['branch' => 'Центрально-Черноземный банк'],

		// Юго-Западный банк
		'RU-ROS' => ['branch' => 'Юго-Западный банк'],
		'RU-KDA' => ['branch' => 'Юго-Западный банк'],
		'RU-AD'  => ['branch' => 'Юго-западный банк'],
		'RU-STA' => ['branch' => 'Юго-западный банк'],
		'RU-SE'  => ['branch' => 'Юго-Западный банк'],
		'RU-KB'  => ['branch' => 'Юго-западный банк'],
		'RU-IN'  => ['branch' => 'Юго-Западный банк'],
		'RU-DA'  => ['branch' => 'Юго-западный банк'],
		'RU-KC'  => ['branch' => 'Юго-Западный банк'],
		'RU-KL'  => ['branch' => 'Юго-Западный банк'],
		'RU-CE'  => ['branch' => 'Юго-западный банк'],
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'atm',
		'ref'             => '',
		'name'            => 'Сбербанк',
		'name:ru'         => 'Сбербанк',
		'name:en'         => 'Sberbank',
		'operator'        => 'ПАО "Сбербанк"', // https://www.cbr.ru/credit/coinfo.asp?id=350000004
		'branch'          => '',
		'contact:website' => 'http://www.sberbank.ru',
		'contact:phone'   => '+7 495 5005550',
		'currency:RUR'    => 'no',
		'currency:USD'    => 'no',
		'currency:EUR'    => 'no',
		'cash_in'         => 'no',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'wikipedia'       => 'ru:Сбербанк_России',
		'wikidata'        => 'Q205012'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=atm][operator~"Сбербанк",i]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$this->log('Обновление данных по региону '.$this->region.'.');

		global $RU;

		// Загрузка bbox региона
		$bbox = $this->get_bbox($this->region);
		if (is_null($bbox)) {
			return;
		}

		$maxcount = 180; // максимальное количество страниц
		$count =    0;   // номер страницы
		$size =     99;  // количество отделений на странице

		while ($count < $maxcount) {
			$url = 'https://www.sberbank.ru/portalserver/proxy?pipe=branchesPipe&url=http%3A%2F%2Foib-rs%2Foib-rs%2FbyBounds%2Fentities'
			.'%3Fllat%3D'
			.$bbox['minlat']
			.'%26llon%3D'
			.$bbox['minlon']
			.'%26rlat%3D'
			.$bbox['maxlat']
			.'%26rlon%3D'
			.$bbox['maxlon']
			.'%26size%3D'
			.$size
			.'%26page%3D'
			.$count
			.'%26cbLat%3D'
			.$RU[$this->region]['lat']
			.'%26cbLon%3D'
			.$RU[$this->region]['lon']
			.'%26filter%255Btype%255D%255B%255D%3Datm';

			$page = $this->get_web_page($url);
			if (is_null($page)) {
				return;
			}

			$this->parse($page);
			++$count;

		}
	}

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (!isset($a)) {
			return;
		}

		foreach ($a as $obj) {

			// Координаты
			$obj['lat'] = $obj['coordinates']['latitude'];
			$obj['lon'] = $obj['coordinates']['longitude'];

			// Отсеиваем по региону
			if (!$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			// Приём наличных
			if ($obj['cashin'] == true) {
				$obj['cash_in'] = 'yes';
			}

			$obj['branch'] = static::$urls[$this->region]['branch'];
			$obj['_addr'] = $obj['address'];

			$obj['ref'] = $obj['id'];

			// Контакты
			if (isset($obj['phone'])) {
				$obj['contact:phone'] = $this->phone($obj['phone']);
			}

			// Валюты выдачи
			// FIXME: добавить обработку
			$obj['currency:RUR'] = 'yes';
			//$obj['currency:USD'] = 'yes';
			//$obj['currency:EUR'] = 'yes';

			// Режим работы
			if (isset($obj['worktime'])) {
				if ($obj['worktime'] == 'В РЕЖИМЕ РАБОТЫ МЕСТА УСТАНОВКИ') {
					// FIXME: добавить
					// NOTE: может быть в отделении, но иметь другой режим работы
				}
				if ($obj['worktime'] == 'КРУГЛОСУТОЧНО') {
					$obj['opening_hours'] = '24/7';
				}
			}
			//$obj['opening_hours'] = $this->time($time);

			$this->addObject($this->makeObject($obj));
		}
	}
}
