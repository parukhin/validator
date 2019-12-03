<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/common/regions.php';

class sberbank_atm extends Validator
{
	protected $domain = 'https://www.sberbank.ru';

	static $urls = [
		// Байкальский банк
		'RU-ZAB' => ['regId' => '8600', 'branch' => 'Байкальский банк'],
		'RU-IRK' => ['regId' => '8586', 'branch' => 'Байкальский банк'], // eq
		'RU-BU'  => ['regId' => '8586', 'branch' => 'Байкальский банк'], // eq
		'RU-SA'  => ['regId' => '8603', 'branch' => 'Байкальский банк'],

		// Волго-Вятский банк
		'RU-NIZ' => ['regId' => '9042', 'branch' => 'Волго-Вятский банк'],
		'RU-VLA' => ['regId' => '8611', 'branch' => 'Волго-Вятский банк'],
		'RU-KIR' => ['regId' => '8612', 'branch' => 'Волго-Вятский банк'],
		'RU-MO'  => ['regId' => '8589', 'branch' => 'Волго-Вятский банк'],
		'RU-ME'  => ['regId' => '8614', 'branch' => 'Волго-Вятский банк'],
		'RU-CU'  => ['regId' => '8613', 'branch' => 'Волго-Вятский банк'],
		'RU-TA'  => ['regId' => '8610', 'branch' => 'Волго-Вятский банк'],
		'RU-PER' => ['regId' => '6984', 'branch' => 'Волго-Вятский банк'],
		'RU-UD'  => ['regId' => '8618', 'branch' => 'Волго-Вятский банк'],

		// Дальневосточный банк
		'RU-KHA' => ['regId' => '9070', 'branch' => 'Дальневосточный банк'],
		'RU-PRI' => ['regId' => '8635', 'branch' => 'Дальневосточный банк'],
		'RU-AMU' => ['regId' => '8636', 'branch' => 'Дальневосточный банк'],
		'RU-SAK' => ['regId' => '8567', 'branch' => 'Дальневосточный банк'],
		'RU-YEV' => ['regId' => '4157', 'branch' => 'Дальневосточный банк'],
		'RU-MAG' => ['regId' => '8645', 'branch' => 'Дальневосточный банк'], // eq
		'RU-KAM' => ['regId' => '8556', 'branch' => 'Дальневосточный банк'],
		'RU-CHU' => ['regId' => '8645', 'branch' => 'Дальневосточный банк'], // eq

		// Западно-Сибирский банк
		'RU-TYU' => ['regId' => '29',   'branch' => 'Западно-Сибирский банк'],
		'RU-OMS' => ['regId' => '8634', 'branch' => 'Западно-Сибирский банк'],
		'RU-KHM' => ['regId' => '1791', 'branch' => 'Западно-Сибирский банк'],
		'RU-YAN' => ['regId' => '1790', 'branch' => 'Западно-Сибирский банк'],

		// Московский банк
		'RU-MOW' => ['regId' => '9038', 'branch' => 'Московский банк'],

		// Поволжский банк
		'RU-SAM' => ['regId' => '6991', 'branch' => 'Поволжский банк'],
		'RU-ULY' => ['regId' => '8588', 'branch' => 'Поволжский банк'],
		'RU-ORE' => ['regId' => '8623', 'branch' => 'Поволжский банк'],
		'RU-SAR' => ['regId' => '8622', 'branch' => 'Поволжский банк'],
		'RU-VGG' => ['regId' => '8621', 'branch' => 'Поволжский банк'],
		'RU-AST' => ['regId' => '8625', 'branch' => 'Поволжский банк'],
		'RU-PNZ' => ['regId' => '8624', 'branch' => 'Поволжский банк'],

		// Северо-Западный банк
		'RU-SPE' => ['regId' => '9055', 'branch' => 'Северо-Западный банк'], // eq
		'RU-LEN' => ['regId' => '9055', 'branch' => 'Северо-Западный банк'], // eq
		'RU-MUR' => ['regId' => '8627', 'branch' => 'Северо-Западный банк'],
		'RU-KGD' => ['regId' => '8626', 'branch' => 'Северо-Западный банк'],
		'RU-PSK' => ['regId' => '8630', 'branch' => 'Северо-Западный банк'],
		'RU-NGR' => ['regId' => '8629', 'branch' => 'Северо-Западный банк'],
		'RU-KR'  => ['regId' => '8628', 'branch' => 'Северо-Западный банк'],
		'RU-VLG' => ['regId' => '8638', 'branch' => 'Северо-Западный банк'],
		'RU-NEN' => ['regId' => '1582', 'branch' => 'Северо-Западный банк'],
		'RU-ARK' => ['regId' => '8637', 'branch' => 'Северо-Западный банк'],
		'RU-KO'  => ['regId' => '8617', 'branch' => 'Северо-Западный банк'],

		// Сибирский банк
		'RU-NVS' => ['regId' => '8047', 'branch' => 'Сибирский банк'],
		'RU-TOM' => ['regId' => '8616', 'branch' => 'Сибирский банк'],
		'RU-KEM' => ['regId' => '8615', 'branch' => 'Сибирский банк'],
		'RU-ALT' => ['regId' => '8644', 'branch' => 'Сибирский банк'],
		'RU-AL'  => ['regId' => '8558', 'branch' => 'Сибирский банк'],
		'RU-KYA' => ['regId' => '8646', 'branch' => 'Сибирский банк'],
		'RU-TY'  => ['regId' => '8591', 'branch' => 'Сибирский банк'],
		'RU-KK'  => ['regId' => '8602', 'branch' => 'Сибирский банк'],

		// Среднерусский банк
		'RU-MOS' => ['regId' => '9040', 'branch' => 'Среднерусский банк'],
		'RU-TVE' => ['regId' => '8607', 'branch' => 'Среднерусский банк'],
		'RU-KLU' => ['regId' => '8608', 'branch' => 'Среднерусский банк'],
		'RU-BRY' => ['regId' => '8605', 'branch' => 'Среднерусский банк'],
		'RU-SMO' => ['regId' => '8609', 'branch' => 'Среднерусский банк'],
		'RU-TUL' => ['regId' => '8604', 'branch' => 'Среднерусский банк'],
		'RU-RYA' => ['regId' => '8606', 'branch' => 'Среднерусский банк'],
		'RU-YAR' => ['regId' => '17',   'branch' => 'Среднерусский банк'],
		'RU-KOS' => ['regId' => '8640', 'branch' => 'Среднерусский банк'],
		'RU-IVA' => ['regId' => '8639', 'branch' => 'Среднерусский банк'],

		// Уральский банк
		'RU-SVE' => ['regId' => '7003', 'branch' => 'Уральский банк'],
		'RU-CHE' => ['regId' => '8597', 'branch' => 'Уральский банк'],
		'RU-KGN' => ['regId' => '8599', 'branch' => 'Уральский банк'],
		'RU-BA'  => ['regId' => '8598', 'branch' => 'Уральский банк'],

		// Центрально-Черноземный банк
		'RU-VOR' => ['regId' => '9013', 'branch' => 'Центрально-Черноземный банк'],
		'RU-ORL' => ['regId' => '8595', 'branch' => 'Центрально-Черноземный банк'],
		'RU-LIP' => ['regId' => '8593', 'branch' => 'Центрально-Черноземный банк'],
		'RU-KRS' => ['regId' => '8596', 'branch' => 'Центрально-Черноземный банк'],
		'RU-BEL' => ['regId' => '8592', 'branch' => 'Центрально-Черноземный банк'],
		'RU-TAM' => ['regId' => '8594', 'branch' => 'Центрально-Черноземный банк'],

		// Юго-Западный банк
		'RU-ROS' => ['regId' => '5221', 'branch' => 'Юго-Западный банк'],
		'RU-KDA' => ['regId' => '8619', 'branch' => 'Юго-Западный банк'],
		'RU-AD'  => ['regId' => '8620', 'branch' => 'Юго-западный банк'],
		'RU-STA' => ['regId' => '5230', 'branch' => 'Юго-западный банк'],
		'RU-SE'  => ['regId' => '8632', 'branch' => 'Юго-Западный банк'],
		'RU-KB'  => ['regId' => '8631', 'branch' => 'Юго-западный банк'],
		'RU-IN'  => ['regId' => '8633', 'branch' => 'Юго-Западный банк'],
		'RU-DA'  => ['regId' => '8590', 'branch' => 'Юго-западный банк'],
		'RU-KC'  => ['regId' => '8585', 'branch' => 'Юго-Западный банк'],
		'RU-KL'  => ['regId' => '8579', 'branch' => 'Юго-Западный банк'],
		'RU-CE'  => ['regId' => '8643', 'branch' => 'Юго-западный банк'],
	];


	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'atm',
		'ref'             => '',
		'name'            => 'Сбербанк',
		'name:ru'         => 'Сбербанк',
		'name:en'         => 'Sberbank',
		'operator'        => 'ПАО Сбербанк', // https://www.cbr.ru/credit/coinfo.asp?id=350000004
		'branch'          => '',
		'contact:website' => 'https://www.sberbank.ru',
		'contact:phone'   => '+7 495 5005550',
		'currency:RUB'    => 'no',
		'currency:USD'    => 'no',
		'currency:EUR'    => 'no',
		'cash_in'         => 'no',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand:wikipedia' => 'ru:Сбербанк России',
		'brand:wikidata'  => 'Q205012'
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
			$obj['currency:RUB'] = 'yes';
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
