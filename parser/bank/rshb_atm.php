<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class rshb_atm extends Validator
{
	protected $domain = 'https://www.rshb.ru/api/v1/atms?regionCode=';

	static $urls = [
    'RU-ALT' => ['id' => '018'], // Алтайский край
    'RU-AMU' => ['id' => '023'], // Амурская область
    'RU-ARK' => ['id' => '048'], // Архангельская область
    'RU-BA'  => ['id' => '062'], // Республика Башкортостан
    'RU-BEL' => ['id' => '030'], // Белгородская область
    'RU-BRY' => ['id' => '069'], // Брянская область
    'RU-BU'  => ['id' => '059'], // Республика Бурятия
    'RU-VLA' => ['id' => '041'], // Владимирская область
    'RU-VGG' => ['id' => '046'], // Волгоградская область
    'RU-VOR' => ['id' => '014'], // Воронежская область
    'RU-DA'  => ['id' => '004'], // Республика Дагестан
    'RU-IVA' => ['id' => '038'], // Ивановская область
    'RU-IRK' => ['id' => '066'], // Иркутская область
    'RU-KB'  => ['id' => '044'], // Кабардино-Балкарская Республика
    'RU-KGD' => ['id' => '055'], // Калининградская область
    'RU-KLU' => ['id' => '027'], // Калужская область
    'RU-KAM' => ['id' => '053'], // Камчатский край
    'RU-KEM' => ['id' => '056'], // Кемеровская область
    'RU-KIR' => ['id' => '022'], // Кировская область
    'RU-KO'  => ['id' => '074'], // Республика Коми
    'RU-KOS' => ['id' => '051'], // Костромская область
    'RU-KDA' => ['id' => '003'], // Краснодарский край
    'RU-KYA' => ['id' => '049'], // Красноярский край
    'RU-KUR' => ['id' => '032'], // Курская область
    'RU-LIP' => ['id' => '024'], // Липецкая область
    'RU-ME'  => ['id' => '016'], // Республика Марий Эл
    'RU-MO'  => ['id' => '020'], // Республика Мордовия
	'RU-MOS' => ['id' => '063'], // Московская область
	'RU-MOW' => ['id' => '063'], // Москва
    'RU-NIZ' => ['id' => '039'], // Нижегородская область
    'RU-NVS' => ['id' => '025'], // Новосибирская область
    'RU-OMS' => ['id' => '009'], // Омская область
    'RU-ORE' => ['id' => '005'], // Оренбургская область
    'RU-ORL' => ['id' => '010'], // Орловская область
    'RU-PNZ' => ['id' => '015'], // Пензенская область
    'RU-PER' => ['id' => '076'], // Пермская область
    'RU-PRI' => ['id' => '054'], // Приморский край
    'RU-PSK' => ['id' => '068'], // Псковская область
    'RU-ROS' => ['id' => '007'], // Ростовская область
    'RU-RYA' => ['id' => '058'], // Рязанская область
    'RU-SAM' => ['id' => '013'], // Самарская область
    'RU-SPE' => ['id' => '035'], // Санкт-Петербург
    'RU-SAR' => ['id' => '052'], // Саратовская область
    'RU-SAK' => ['id' => '072'], // Сахалинская область
    'RU-SVE' => ['id' => '073'], // Свердловская область
    'RU-SMO' => ['id' => '043'], // Смоленская область
    'RU-STA' => ['id' => '006'], // Ставропольский край
    'RU-TAM' => ['id' => '002'], // Тамбовская область
    'RU-TA'  => ['id' => '067'], // Республика Татарстан
    'RU-TVE' => ['id' => '019'], // Тверская область
    'RU-TOM' => ['id' => '064'], // Томская область
    'RU-TY'  => ['id' => '057'], // Республика Тыва
    'RU-TUL' => ['id' => '001'], // Тульская область
    'RU-TYU' => ['id' => '071'], // Тюменская область
    'RU-UD'  => ['id' => '028'], // Удмуртская Республика
    'RU-ULY' => ['id' => '065'], // Ульяновская область
    'RU-KHA' => ['id' => '075'], // Хабаровский край
    'RU-CHE' => ['id' => '078'], // Челябинская область
    'RU-CE'  => ['id' => '034'], // Чеченская Республика
    'RU-ZAB' => ['id' => '047'], // Забайкальский край
    'RU-CU'  => ['id' => '011'], // Чувашская Республика
    'RU-SA'  => ['id' => '060'], // Республика Саха (Якутия)
    'RU-YAR' => ['id' => '061'] // Ярославская область
];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'atm',
		'ref'             => '',
		'name'            => '',
		'name:ru'         => '',
		'official_name'   => '',
		'operator'        => 'АО "Россельхозбанк"', // https://cbr.ru/finorg/foinfo/?ogrn=1027700342890
		'branch'          => '',
		'contact:website' => 'https://www.rshb.ru/',
		'contact:phone'   => '+7 800 1000100;+7 495 7877787;+7 800 1007870',
		'currency:RUB'    => 'no',
		'currency:USD'    => 'no',
		'currency:EUR'    => 'no',
		'cash_in'         => 'no',
		'wheelchair'      => '',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand'           => 'Россельхозбанк',
		'brand:wikidata'  => 'Q3920226'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=atm][operator~"Россельхозбанк",i]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$id = static::$urls[$this->region]['id'];
		$url = $this->domain.$id;

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
		foreach ($st as $obj) {
			// Координаты
			$obj['lat'] = $obj['gpsLatitude'];
			$obj['lon'] = $obj['gpsLongitude'];

			// Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			// Идентификатор
			$obj['ref'] =  $obj['atmCode'];

			// Адрес
			$obj['_addr'] = $obj['address'];

			// Время работы
			$obj['opening_hours'] = $this->time($obj['workTime']);

			// Доступность для инвалидных колясок
			if ($obj['locationDisabledPeople'] == 'true') {
				$obj['wheelchair'] = 'yes';
			} else {
				$obj['wheelchair'] = 'no';
			}

			// Приём наличных
			if ($obj['billAcceptorEnable'] == true) {
				$obj['cash_in'] = 'yes';
			}

			// Валюты (выдача) сейчас в JSON только RUR
			$currencyList = array_map('trim', explode(',', $obj['currencies']));
			foreach ($currencyList as $currency) {
				switch ($currency) {
					case 'RUR':
						$obj['currency:RUB'] = 'yes';
						break;
					case 'USD':
						$obj['currency:USD'] = 'yes';
						break;
					case 'EUR':
						$obj['currency:EUR'] = 'yes';
						break;
					default:
						$this->log("Parse error! (rshb_atm: Неизвестный код валюты: '$currency').");
						break;
				}
			}

			// ограничение доступа
			if ($obj['atmAccess'] == 'ограниченный доступ') {
				$obj['access'] = 'private';
			}

			$this->addObject($this->makeObject($obj));
		}
	}
}
