<?php
require_once 'Validator.class.php';

class russian_post extends Validator
{
	// откуда скачиваем данные
	protected $domain = 'https://www.pochta.ru/';
	static $urls = array(
        'RU-ARK' => array(
            'lat' => '64',
            'lon' => '41',
            'region' => 'Архангельская обл',
            'count' => 1400,
        ),
        'RU-BRY' => array(
            'lat' => '52.95',
            'lon' => '34.04',
            'region' => 'Брянская обл',
            'count' => 1400,
        ),
        'RU-BEL' => array(
            'lat' => '50.80',
            'lon' => '37.66',
            'region' => 'Белгородская обл',
            'count' => 1400,
        ),
        'RU-CU' => array(
            'lat' => '55.48',
            'lon' => '47.19',
            'region' => 'Чувашская Республика - Чувашия',
            'count' => 700,
        ),
        'RU-KDA' => array(
            'lat' => '45.143',
            'lon' => '39.133',
            'region' => 'Краснодарский край',
            'count' => 2000,
        ),
        'RU-KEM' => array(
            'lat' => '54.56',
            'lon' => '86.93',
            'region' => 'Кемеровская обл',
            'count' => 1600,
        ),
        'RU-KHA'=> array(
            'lat' => '55.37',
            'lon' => '138.80',
            'region' => 'Хабаровский край',
            'count' => 1280,
        ),
        'RU-KHM'=> array(
            'lat' => '62.41',
            'lon' => '72.9',
            'region' => 'Ханты-Мансийский Автономный округ - Югра АО',
            'count' => 1000,
        ),
        'RU-KGD' => array(
            'lat' => '54.71',
            'lon' => '21.58',
            'region' => 'Калининградская обл',
            'count' => 300,
        ),
        'RU-KIR' => array(
            'lat' => '58.65',
            'lon' => '50.098',
            'region' => 'Кировская обл',
            'count' => 1792,
        ),
        'RU-KYA' => array(
            'lat' => '71.75',
            'lon' => '94.92',
            'region' => 'Красноярский край',
            'count' => 6000,
        ),
        'RU-LIP' => array(
            'lat' => '52.75',
            'lon' => '39.28',
            'region' => 'Липецкая обл',
            'count' => 1280,
        ),
        'RU-LEN' => array(
            'lat' => '60.03',
            'lon' => '30.50',
            'region' => 'Ленинградская обл',
            'count' => 1300,
        ),
        'RU-MOS' => array(
            'lat' => '55.75396',
            'lon' => '37.620393',
            'region' => 'Московская обл',
            'count' => 2500,
        ),
        'RU-MOW' => array(
            'lat' => '55.59',
            'lon' => '37.37',
            'region' => 'Москва г',
            'count' => 1000,
        ),
        'RU-MUR' => array(
            'lat' => '67.9',
            'lon' => '34.89',
            'region' => 'Мурманская обл',
            'count' => 256,
        ),
        'RU-RYA' => array(
            'lat' => '54.34',
            'lon' => '40.68',
            'region' => 'Рязанская обл',
            'count' => 1000,
        ),
        'RU-TVE' => array(
            'lat' => '57.28',
            'lon' => '34.53',
            'region' => 'Тверская обл',
            'count' => 2000,
        ),
		'RU-ROS' => array(
		    'lat' => '47.222531',
            'lon' => '39.718705',
            'region' => 'Ростовская обл',
            'count' => 3000,
		),
        'RU-SPE' => array(
            'lat' => '60.03',
            'lon' => '30.50',
            'region' => 'Санкт-Петербург г',
            'count' => 400,
        ),
        'RU-AD' => array(
            'lat' => '44.512',
            'lon' => '39.792',
            'region' => 'Адыгея Респ',
            'count' => 600,
        ),
        'RU-TA' => array(
            'lat' => '55.360',
            'lon' => '50.801',
            'region' => 'Татарстан Респ',
            'count' => 2700,
        ),
        'RU-PNZ' => array(
            'lat' => '53.170',
            'lon' => '44.533',
            'region' => 'Пензенская обл',
            'count' => 1300,
        ),
        'RU-BA' => array(
            'lat' => '54.124',
            'lon' => '56.580',
            'region' => 'Башкортостан Респ' ,
            'count' => 2500,
        ),
        'RU-CHE' => array(
            'lat' => '54.444',
            'lon' => '60.535',
            'region' => 'Челябинская обл',
            'count' => 1500,
        ),
        'RU-VLA' => array(
            'lat' => '55.96',
            'lon' => '40.622',
            'region' => 'Владимирская обл',
            'count' => 1100,
        ),
        'RU-PER' => array(
            'lat' => '59.052',
            'lon' => '55.767',
            'region' => 'Пермский край',
            'count' => 1664,
        ),
        'RU-NVS' => array(
            'lat' => '55.342',
            'lon' => '80.156',
            'region' => 'Новосибирская обл',
            'count' => 1300,
        ),
        'RU-OMS' => array(
            'lat' => '56.19',
            'lon' => '73.411',
            'region' => 'Омская обл',
            'count' => 1000,
        ),
        'RU-IRK' => array(
            'lat' => '58.03',
            'lon' => '108.237',
            'region' => 'Иркутская обл',
            'count' => 1300,
        ),
        'RU-PRI' => array(
            'lat' => '45.41',
            'lon' => '134.91',
            'region' => 'Приморский край',
            'count' => 1664,
        ),
       'RU-ULY' => array(
            'lat' => '53.74',
            'lon' => '48.02',
            'region' => 'Ульяновская обл',
            'count' => 1200,
        ),
        'RU-VGG' => array(
            'lat' => '49.368',
            'lon' => '44.297',
            'region' => 'Волгоградская обл',
            'count' => 1500,
        ),
        'RU-VLG' => array(
            'lat' => '59.220492',
            'lon' => '39.891568',
            'region' => 'Вологодская обл',
            'count' => 5000,
        ),
        'RU-VOR' => array(
            'lat' => '50.85',
            'lon' => '40.54',
            'region' => 'Воронежская обл',
            'count' => 2000,
        ),
        'RU-IVA' => array(
            'lat' => '57.01',
            'lon' => '41.31',
            'region' => 'Ивановская обл',
            'count' => 2000,
        ),
    );

	// поля объекта
	protected $fields = array(
		'amenity'  => 'post_office',
		'name'     => '',
		'operator' => 'Почта России',
		'contact:website' => 'https://www.pochta.ru',
		'ref'      => '',
		'opening_hours' => '',
		'contact:phone' => '',
		'lat'   => '',
		'lon'   => '',
		'_name' => '',
		'_addr' => '',
		);

	// фильтр для поиска объектов в OSM
    protected $filter = array(
        '[amenity=post_office]'
    );

	/* Обновление данных по региону */
	public function update()
	{
		//запрашиваеем что-то недалеко от центра...
		$this->log('Update real data '.$this->region);

        $maxcount = 4000;
        if (isset(static::$urls[$this->region]['count']))
            $maxcount = static::$urls[$this->region]['count'];

        $count = 64;
		$url = 'https://www.pochta.ru/portal-portlet/delegate/postoffice-api/method/offices.find.nearby.details?latitude='.static::$urls[$this->region]['lat'].'&longitude='.static::$urls[$this->region]['lon'].'&top='.$count.'&currentDateTime=2016-2-28T2%3A12%3A22&filter=ALL&hideTemporaryClosed=false&fullAddressOnly=true&searchRadius=10000&offset=';

		$offset = 0;
		while($offset < $maxcount)
		{
			$page = $this->download($url.$offset);
			$this->parse($page);
			$offset+= $count;
            //echo 'offset: '.$offset.' objects: '.count($this->objects)."\n";
		}
	}

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
        if (!isset($a))
            return;

		foreach ($a as $obj)
        {
			// Если вылезли в соседние регионы
			if ($obj['region'] != static::$urls[$this->region]['region']) {
                continue;
            }

            // Исключение передвижных отделений из поиска (typeId = 18, typeCode = "ПОПС")
            if ($obj['typeId'] == 18)
                continue;
            
			$dup = false;
			foreach ($this->objects as $obj_s)
				if ($obj_s['ref'] == $obj['postalCode'])
				{
					$dup = true;
					break;
				}

			if ($dup == true)
				continue;

            $obj['_addr'] = $obj['settlement'].', '.$obj['addressSource'];
            $obj['ref'] = $obj['postalCode'];
			$obj['name'] = 'Отделение связи №'.$obj['ref'];

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
                $currentTime = '';
                $previousTime = '';
                $firstWeekDayId = 1;
                $lastWeekDayId = 1;

                foreach ($obj['workingHours'] as $wh) {

                    /* Записываем день недели */
                    if (!isset($wh['beginWorkTime'])) // выходной
                    {
                        $currentTime = "off";
                    }
                    else // рабочий день
                    {

                        if (isset($wh['lunches']) && (count($wh['lunches']) > 0)) // есть обеденный перерыв
                        {
                            $currentTime = substr($wh['beginWorkTime'], 0,5).'-'.substr($wh['lunches'][0]['beginLunchTime'], 0,5).',';
                            $currentTime .= substr($wh['lunches'][0]['endLunchTime'], 0,5).'-'.substr($wh['endWorkTime'], 0,5);
                        } 
                        else // без перерыва
                        {
                            $currentTime = substr($wh['beginWorkTime'], 0,5).'-'.substr($wh['endWorkTime'], 0,5);
                        }
                    }

                    /* Запись */
                    if ($previousTime != '') // в 1 раз не записываем
                    {
                        if (strcasecmp($currentTime, $previousTime) == 0)
                        {
                            $lastWeekDayId = $wh['weekDayId'];
                        }
                        else
                        {
                            if ($lastWeekDayId > $firstWeekDayId)
                            {
                                $time .= $wd[$firstWeekDayId - 1].'-'.$wd[$lastWeekDayId - 1].' '.$previousTime."; ";
                            }
                            else
                            {
                                $time .= $wd[$firstWeekDayId - 1].' '.$previousTime."; ";
                            }
                            $firstWeekDayId = $wh['weekDayId'];
                        }
                    }
                    $previousTime = $currentTime;
                    
                }

                /* Записываем последний день */
                if ($lastWeekDayId > $firstWeekDayId)
                {
                    $time .= $wd[$firstWeekDayId - 1].'-'.$wd[$lastWeekDayId - 1].' '.$previousTime;
                }
                else
                {
                    $time .= $wd[$firstWeekDayId - 1].' '.$previousTime;
                }

                $obj['opening_hours'] = $time;
                // FIXME: перевести на универсальную функцию
            }
            $obj['lat'] = $obj['latitude'];
            $obj['lon'] = $obj['longitude'];

            $this->addObject($this->makeObject($obj));
        }
	}
}
