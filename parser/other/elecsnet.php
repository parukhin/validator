<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class elecsnet extends Validator
{
	protected $domain = 'http://www.elecsnet.ru';

	static $urls = [
		//http://elecsnet.ru/gmap/DeArtus/ArtusGetPoints.aspx?h24=0&swLat=56.94610173079548&swLng=40.92715835571289&neLat=56.99943200557173&neLng=41.05247116088867&zoom=13
		'RU-MOW' => '/gmap/DeArtus/ArtusGetPoints.aspx?h24=0&swLat=55.25531367777988&swLng=36.576650619506836&neLat=56.137576936232506&neLng=38.581655502319336&zoom=17',
		'RU-MOS' => '/gmap/DeArtus/ArtusGetPoints.aspx?h24=0&swLat=54.83268313317916&swLng=35.502214431762695&neLat=56.59612204819024&neLng=39.512224197387695&zoom=17',
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'payment_terminal',
		'ref'             => '',
		'name'            => 'Элекснет',
		'name:ru'         => 'Элекснет',
		'name:en'         => 'Elecsnet',
		'brand'           => 'elecsnet',
		'payment:notes'   => 'yes',
		'contact:phone'   => '+7 495 7872964',
		'contact:website' => '',
		'opening_hours'   => '',
		'_note'           => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'operator:wikidata'        => '',
		'operator:wikipedia'       => ''
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=payment_terminal][brand=elecsnet]',
	];

	/* Обновление данных по региону */
	public function update()
	{
		$this->log('Обновление данных по региону '.$this->region.'.');

		$id = static::$urls[$this->region];

		$url = "https://4lapy.ru/ajax/ajax.php";
		$query = "operation=get-list-shop-on-map&filter-region=$id&filter-city=";

		$page = $this->get_web_page($url, $query);
		if (is_null($page)) {
			return;
		}

		$this->parse($page);
	}

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a->d as $obj) {
			$obj['lat'] = $obj[0];
			$obj['lon'] = $obj[1];
			$obj['ref'] = $obj[2];
			//$obj['note'] = 'SUM: '.$obj[3];

			//После получения "основных" сведений, детализируем.
			$detailPage = $this->download('http://elecsnet.ru/gmap/DeArtus/ArtusGetTerminalInfo.aspx?id='.$obj['ref']);
			//получаем нечто вида
			//{"d":{"__type":"Terminal","id":14340,"region":"Москва г.","city":"Москва г.",
			//"address":"Боровское ш., д. 6 (14340)",
			//"objtype":"Торговый центр",
			//"place":"\"Солнечный рай\"",
			//"metro":"Юго-западная",
			//"route":"Первый этаж, рядом с лестницей на второй этаж",
			//"time":"09:00-22:00","status":"Банкомат работает.",
			//"gps_lt":"55.658794","gps_ln":"37.401905","restriction":"Ограничений нет"}}
			$detail = json_decode($detailPage);
			if ($detail != null) {
				//if ($detail->d->id != "14340")
				//	continue;

				//Если вылезли в соседние регионы
				if ($detail->d->region != static::$options[$this->region]) {
					continue;
				}


				$obj['_addr'] = substr($detail->d->address, 0, strlen($detail->d->address)-8);

				$obj['_note'] = '';
				if(isset($detail->d->place))
					$obj['_note'] .= $detail->d->place."\n";
				$obj['_note'] .= $detail->d->route;
				//if ($detail->d->restriction != "Ограничений нет")
				//	$obj['note'] .= 'RESTRICTION: '.$detail->d->restriction;
				$obj['opening_hours'] = $this->time($detail->d->time);
			}

			$this->addObject($this->makeObject($obj));
		}
	}
}
