<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class ulybka_radugi extends Validator
{
	// откуда скачиваем данные
	protected $domain = 'https://bff.r-ulybka.ru/api/stores';

	// TODO добавить остальные регионы
	static $urls = [
		'RU'     => '', // Россия
		'RU-VLA' => '', // Владимирская область
		'RU-IVA' => '', // Ивановская область
		'RU-KAL' => '', // Калужская область
		'RU-MOS' => '', // Московская область
		'RU-MOW' => '', // Москва
		'RU-NIZ' => '', // Нижегородская область
		'RU-NGR' => '', // Новгородская область
		'RU-PSK' => '', // Псковская область
		'RU-BA'  => '', // Республика Башкортостан
		'RU-ME'  => '', // Республика Марий Эл
		'RU-TA'  => '', // Республика Татарстан
		'RU-TVE' => '', // Тверская область
		'RU-CU'  => '', // Чувашская Республика
		'RU-UD'  => '', // Удмуртская Республика
		'RU-YAR' => '', // Ярославская область
		'RU-SPE' => '', // Санкт-Петербург
		'RU-LEN' => '' // Ленинградская область
	];

	// поля объекта
	protected $fields = [
		'shop'    		    => 'chemist',
		'name'    			=> 'Улыбка радуги',
		'brand'    			=> 'Улыбка радуги',
		'operator' 			=> '',
		'contact:website'  	=> 'https://www.r-ulybka.ru/',
		'contact:phone'   	=> '+7 800 5056600',
		'opening_hours'   	=> '',
		'ref'   			=> '',
		'lat'   			=> '',
		'lon'   			=> '',
		'_addr' 			=> '',
		'brand:wikidata'    => 'Q109734104',
		'brand:wikipedia'   => 'ru:Улыбка радуги'

	];

	// фильтр для поиска объектов в OSM
    protected $filter = array(
        '[shop][name~"Улыбка радуги",i]'
    );

	public function update()
	{
		$url = 'https://bff.r-ulybka.ru/api/stores?limit=0&retailPoint=true&sortBy=geoCoordinates+asc&fields[]=id&fields[]=code&fields[]=geoCoordinates&fields[]=subwayStations&fields[]=openingHours&fields[]=address&fields[]=retailPoint&fields[]=new&fields[]=openingSoon&fields[]=temporaryClosed&fields[]=active&fields[]=underReconstruction&fields[]=pickupPoint&fields[]=dateOpening&pinLocation=55.741272,52.403662';
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

		foreach ($st['_embedded']['items']  as $obj) {
			$obj['lat'] = $obj['geoCoordinates'][1];
			$obj['lon'] = $obj['geoCoordinates'][0];

            // Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			$obj['ref'] = $obj['code'];
			$obj['_addr'] = $obj['address'];

			// Время работы
			if ($obj['temporaryClosed'] == 'true' || $obj['underReconstruction'] == 'true') {
				$obj['opening_hours'] = 'off';
			} else {
				if (isset($obj['openingHours'])) {

					$wd = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
					$time = [];

					foreach ($obj['openingHours'] as $day => $wh) {
						$time[$wd[$wh['weekDay'] - 1]] = substr($wh['openAt'], 0, 5).'-'.substr($wh['closeAt'], 0, 5);
					}
					$obj['opening_hours'] = $this->time($time);
				}
			}

			$this->addObject($this->makeObject($obj));
		}
	}
}
