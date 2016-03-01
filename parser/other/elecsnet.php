<?php
require_once 'Validator.class.php';

class elecsnet extends Validator
{
	// откуда скачиваем данные
	protected $domain = 'http://www.elecsnet.ru';
	static $urls = array(
		'RU-MOW' => '/gmap/DeArtus/ArtusGetPoints.aspx?h24=0&swLat=55.25531367777988&swLng=36.576650619506836&neLat=56.137576936232506&neLng=38.581655502319336&zoom=17',
		'RU-MOS' => '/gmap/DeArtus/ArtusGetPoints.aspx?h24=0&swLat=54.83268313317916&swLng=35.502214431762695&neLat=56.59612204819024&neLng=39.512224197387695&zoom=17',
	);

	//region":"Москва г."
	static $options = array(
		'RU-MOW' => 'Москва г.',
		'RU-MOS' => 'Московская обл.',
	);



	// поля объекта
	protected $fields = array(
		'amenity'           => 'payment_terminal',
        'brand'           	=> 'elecsnet',
        'name'          	=> 'Элекснет',
        'payment:notes'     => 'yes',
		'phone'     		=> '+7 495 7872964',
        'ref'               => '',
		'lat'               => '',
		'lon'               => '',
		'opening_hours'     => '',
		'_note'              => '',
        '_addr'             => '',
		);

	// фильтр для поиска объектов в OSM
	protected $filter = array(
        '[amenity=payment_terminal][brand=elecsnet]',
        );

	// парсер страницы
	protected function parse($st)
	{
		$a = json_decode($st);
		//echo 'Last error: '.json_last_error();

		foreach ($a->d as $obj)
        {
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
			if ($detail!= null)
			{
				//if ($detail->d->id != "14340")
				//	continue;

				//Если вылезли в соседние регионы
				if ($detail->d->region != static::$options[$this->region])
					continue;


				$obj['_addr'] = substr($detail->d->address, 0, strlen($detail->d->address)-8);

				$obj['_note'] = '';
				if(isset($detail->d->place))
					$obj['_note'] .= $detail->d->place."\n";
				$obj['_note'] .= $detail->d->route;
				//if ($detail->d->restriction != "Ограничений нет")
				//	$obj['note'] .= 'RESTRICTION: '.$detail->d->restriction;
				$obj['opening_hours'] = $this->time($detail->d->time);
			}

			//$obj['_addr'] = substr($obj['Address'], 6);
            //$obj['ref'] = sprintf("%d", $obj['Id']);

            $this->addObject($this->makeObject($obj));
        }
	}
}
