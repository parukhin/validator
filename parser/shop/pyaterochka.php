<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class pyaterochka extends Validator
{
	protected $domain = 'https://5ka.ru/api/stores/?bbox=';

	static $urls = [
		'RU-ARK' => [],
		'RU-AST' => [],
		'RU-BEL' => [],
		'RU-BRY' => [],
		'RU-VLA' => [],
		'RU-VGG' => [],
		'RU-VLG' => [],
		'RU-VOR' => [],
		'RU-IVA' => [],
		'RU-KLU' => [],
		'RU-KC'  => [],
		'RU-KEM' => [],
		'RU-KIR' => [],
		'RU-KOS' => [],
		'RU-KDA' => [],
		'RU-KGN' => [],
		'RU-KRS' => [],
		'RU-LEN' => [],
		'RU-LIP' => [],
		'RU-MOW' => [],
		'RU-MOS' => [],
		'RU-MUR' => [],
		'RU-NIZ' => [],
		'RU-NGR' => [],
		'RU-OMS' => [],
		'RU-ORE' => [],
		'RU-ORL' => [],
		'RU-PNZ' => [],
		'RU-PER' => [],
		'RU-PSK' => [],
		'RU-AD'  => [],
		'RU-BA'  => [],
		'RU-DA'  => [],
		'RU-KR'  => [],
		'RU-KO'  => [],
		'RU-ME'  => [],
		'RU-MO'  => [],
		'RU-TA'  => [],
		'RU-UD'  => [],
		'RU-KK'  => [],
		'RU-ROS' => [],
		'RU-RYA' => [],
		'RU-SAM' => [],
		'RU-SPE' => [],
		'RU-SAR' => [],
		'RU-SVE' => [],
		'RU-SMO' => [],
		'RU-STA' => [],
		'RU-TAM' => [],
		'RU-TVE' => [],
		'RU-TUL' => [],
		'RU-TYU' => [],
		'RU-ULY' => [],
		'RU-KHM' => [],
		'RU-CHE' => [],
		'RU-CU'  => [],
		'RU-YAR' => []
	];

	/* Поля объекта */
	protected $fields = [
		'shop'            => 'convenience',
		'ref'             => '',
		'name'            => 'Пятёрочка',
		'name:ru'         => 'Пятёрочка',
		'name:en'         => 'Pyatyorochka',
		'operator'        => 'X5 Retail Group',
		'contact:website' => 'https://5ka.ru',
		'contact:phone'   => '+7 800 5555505',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand:wikidata'  => 'Q1768969',
		'brand:wikipedia' => 'ru:Пятёрочка'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[shop][name~"Пят[её]рочка",i]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$this->log('Обновление данных по региону '.$this->region.'.');

		// Загрузка bbox региона
		$bbox = $this->get_bbox($this->region);
		if (is_null($bbox)) {
			return;
		}

		$url = $this->domain.$bbox['minlat'].','.$bbox['minlon'].','.$bbox['maxlat'].','.$bbox['maxlon'];

		$page = $this->get_web_page($url);
		if (is_null($page)) {
			return;
		}

		// Удаляем мусор из ответа
		$page = substr($page, 9);
		$page = substr($page, 0, -2);

		$this->parse($page);
	}

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a['data']['features'] as $obj) {

			$obj['ref'] = $obj['id'];

			// Координаты
			$obj['lat'] = $obj['geometry']['coordinates'][0];
			$obj['lon'] = $obj['geometry']['coordinates'][1];

			// Отсеиваем по региону
			if (!$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			// Адрес
			$obj['_addr'] = $obj['properties']['address'];

			// Время работы
			if ($obj['properties']['is_24h'] == true) {
				$obj['opening_hours'] = '24/7';
			} else {
				if (isset($obj['properties']['work_start_time']) && isset($obj['properties']['work_end_time'])) {
					if ((strcmp($obj['properties']['work_start_time'], "00:00:00") !== 0) || (strcmp($obj['properties']['work_end_time'], "00:00:00") !== 0)) {
						$obj['opening_hours'] = substr($obj['properties']['work_start_time'], 0, -3).'-'.substr($obj['properties']['work_end_time'], 0, -3);
					}
				}
			}

			$this->addObject($this->makeObject($obj));
		}
	}
}
