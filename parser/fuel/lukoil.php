<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class lukoil extends Validator
{
	protected $domain = 'https://auto.lukoil.ru/api/cartography/GetSearchObjects?form=gasStation';

	static $urls = [
		'RU-BA'  => '',
		'RU-KGD' => '',
		'RU-KDA' => '',
		'RU-LEN' => '',
		'RU-MOS' => '',
		'RU-MOW' => '',
		'RU-PER' => '',
		'RU-SPE' => '',
		'RU-VLG' => '',
		'RU-VGG' => '',
		'RU-IVA' => ''
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'fuel',
		'ref'             => '',
		'name'            => 'Лукойл',
		'name:ru'         => 'Лукойл',
		'name:en'         => 'Lukoil',
		'brand'           => 'Лукойл',
		'operator'        => '',
		'owner'           => 'ПАО "Лукойл"',
		'contact:website' => 'http://www.lukoil.ru',
		'contact:phone'   => '',
		'opening_hours'   => '24/7',
		'fuel:octane_98'  => '',
		'fuel:octane_95'  => '',
		'fuel:octane_92'  => '',
		'fuel:octane_80'  => '',
		'fuel:diesel'     => '',
		'fuel:lpg'        => '',
		'fuel:cng'        => '',
		'fuel:discount'   => '',
		'atm'             => '', // отд. точка
		'shop'            => '', // отд. точка
		'car_wash'        => '', // отд. точка
		'toilets'         => '', // отд. точка
		'cafe'            => '', // отд. точка
		'compressed_air'  => '', // отд. точка
		'internet_access' => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand:wikidata'  => 'Q329347',
		'brand:wikipedia' => 'ru:Лукойл'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=fuel][name~"Лукойл",i]'
	];

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a['GasStations'] as $obj) {
			// Координаты
			$obj['lat'] = $obj['Latitude'];
			$obj['lon'] = $obj['Longitude'];

			// Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			$obj['ref'] = $obj['GasStationId']; // внутренний ref лукойла, у самих заправок другие номера

			$url = 'https://auto.lukoil.ru/api/cartography/GetObjects?ids=gasStation'.$obj['ref'].'&lng=RU';

			$page = $this->get_web_page($url);
			if (is_null($page)) {
				return;
			}

			$b = json_decode($page, true);
			if (is_null($b)) {
				return;
			}

			$obj['_addr'] = $b[0]['GasStation']['Address'];
			$obj['operator'] = 'ООО '.$b[0]['GasStation']['Company']['Name'];

			/* Виды топлива
			$fuels = [
				'АИ 80'          => 'fuel:octane_80',
				'АИ 87'          => '',
				'АИ 92 ЕВРО'     => 'fuel:octane_92',
				'АИ 92 ЭКТО'     => 'fuel:octane_92',
				'АИ 93'          => '',
				'АИ 95 ЕВРО'     => 'fuel:octane_95',
				'АИ 95 ЭКТО'     => 'fuel:octane_95',
				'АИ 98 ЕВРО'     => 'fuel:octane_98',
				'АИ 98 ЭКТО'     => 'fuel:octane_98',
				'ГАЗ'            => 'fuel:lpg',
				'ДИЗЕЛЬ'         => 'fuel:diesel',
				'ДИЗЕЛЬ ЕВРО'    => 'fuel:diesel',
				'ДИЗЕЛЬ ЭКТО'    => 'fuel:diesel',
				'КЕРОСИН'        => '',
				'МАСЛО'          => '',
				'ПЕЧНОЕ ТОПЛИВО' => '',
				'СНО'            => ''
			]; */
			foreach ($b[0]['Fuels'] as $fuel) {
				switch ($fuel['Name']) {
					case 'АИ 80':
						$obj['fuel:octane_80'] = 'yes';
						break;
					case 'АИ 92 ЕВРО': case 'АИ 92 ЭКТО':
						$obj['fuel:octane_92'] = 'yes';
						break;
					case 'АИ 95 ЕВРО': case 'АИ 95 ЭКТО':
						$obj['fuel:octane_95'] = 'yes';
						break;
					case 'АИ 98 ЕВРО': case 'АИ 98 ЭКТО':
						$obj['fuel:octane_98'] = 'yes';
						break;
					case 'ГАЗ':
						$obj['fuel:lpg'] = 'yes';
						break;
					case 'ДИЗЕЛЬ': case 'ДИЗЕЛЬ ЕВРО': case 'ДИЗЕЛЬ ЭКТО':
						$obj['fuel:diesel'] = 'yes';
						break;
					default:
						break;
				}
			}

			/* Услуги
			$services = [
				'1422121' => 'internet_access', // Wi-Fi
				'1422117' => 'atm',             // Банкомат
				'1422129' => '',                // Возврат сдачи на телефон на автоматической АЗС
				'1676387' => '',                // Выдача карт лояльности (ППКЛ)
				'149697'  => '',                // Гостиница
				'1422135' => 'shop',            // Магазин
				'209845'  => 'car_wash',        // Мойка
				'1676383' => '',                // Накопление и трата баллов лояльности (ППКЛ)
				'1422137' => '',                // Обслуживание карт ППКЛ (Накопление баллов)
				'1676386' => '',                // Обслуживание по виртуальной карте лояльности (ППКЛ)
				'149646'  => '',                // Парковка для большегрузного транспорта
				'1422144' => '',                // Получение карты лояльности на АЗС
				'1422145' => '',                // Пополнение ко-бренд карты "Рапида"
				'149664'  => 'compressed_air',  // Пост подкачки шин
				'1422146' => '',                // Постоплата
				'149704'  => '',                // Прачечная
				'1676388' => '',                // Прием платежей через систему "Рапида"
				'1422148' => '',                // Приобретение ко-бренд карты "Рапида"
				'1422150' => '',                // ПТО
				'1422151' => '',                // Пылесос
				'1422154' => '',                // Специальные условия обслуживания по картам в акциях.
				'12623'   => '',                // Страхование
				'1422156' => '',                // Терминал оплаты
				'149703'  => 'toilets',         // Туалет
				'1422162' => '',                // Туалет для маломобильных групп населения
				'149659'  => ''                 // Шиномонтаж
			]; */
			foreach ($b[0]['GasStation']['Services'] as $service) {
				switch ($service['ServiceId']) {
					case '1422117':
						$obj['atm'] = 'yes';
						break;
					case '1422135':
						$obj['shop'] = 'yes';
						break;
					case '209845':
						$obj['car_wash'] = 'yes';
						break;
					case '149664':
						$obj['compressed_air'] = 'yes';
						break;
					case '149703':
						$obj['toilets'] = 'yes';
						break;
					case '1422121':
						$obj['internet_access'] = 'wlan';
						break;
					default:
						break;
				}
			}

			/*
			$property = [
				'Автоматическая АЗС'          => '',
				'Заправка водного транспорта' => '',
				'Кафе'                        => 'cafe',
				'Кофе-автомат'                => '',
				'ЛИКАРД-ТРАНЗИТ'              => '',
				'Скоростная ТРК'              => ''
			]; */
			foreach ($b[0]['GasStation']['Properties'] as $service) {
				switch ($fuel['Name']) {
					case 'Кафе':
						$obj['cafe'] = 'yes';
						break;
					default:
						break;
				}
			}

			/* Методы оплаты
			$payments = [
				'7'       => '', // Безналичные расчеты по банковским картам VISA/MasterCard
				'2'       => '', // Бе зналичный расчет
				'401'     => '', // Бесконтактные платежи
				'1607057' => '', // Постоплата
				'1001'    => '', // Топливные карты Лукойл
			]; */

			$this->addObject($this->makeObject($obj));
		}
	}
}
