<?php
require_once 'Validator.class.php';

class russian_post extends Validator
{
	// откуда скачиваем данные
	protected $domain = 'https://www.pochta.ru/';
	static $urls = array(
        'RU-ARK' => array(
            'lat' => '64',
            'lng' => '41',
            'region' => 'Архангельская обл',
            'count' => 1400,
        ),
        'RU-BRY' => array(
            'lat' => '52.95',
            'lng' => '34.04',
            'region' => 'Брянская обл',
            'count' => 1400,
        ),
        'RU-BEL' => array(
            'lat' => '50.80',
            'lng' => '37.66',
            'region' => 'Белгородская обл',
            'count' => 1400,
        ),
        'RU-CU' => array(
            'lat' => '55.48',
            'lng' => '47.19',
            'region' => 'Чувашская Республика - Чувашия',
            'count' => 700,
        ),
        'RU-KDA' => array(
            'lat' => '45.143',
            'lng' => '39.133',
            'region' => 'Краснодарский край',
            'count' => 2000,
        ),
        'RU-KEM' => array(
            'lat' => '54.56',
            'lng' => '86.93',
            'region' => 'Кемеровская обл',
            'count' => 1600,
        ),
        'RU-KHA'=> array(
            'lat' => '55.37',
            'lng' => '138.80',
            'region' => 'Хабаровский край',
            'count' => 1280,
        ),
        'RU-KHM'=> array(
            'lat' => '62.41',
            'lng' => '72.9',
            'region' => 'Ханты-Мансийский Автономный округ - Югра АО',
            'count' => 1000,
        ),
        'RU-KGD' => array(
            'lat' => '54.71',
            'lng' => '21.58',
            'region' => 'Калининградская обл',
            'count' => 300,
        ),
        'RU-KIR' => array(
            'lat' => '58.65',
            'lng' => '50.098',
            'region' => 'Кировская обл',
            'count' => 1792,

        ),
        'RU-KYA' => array(
            'lat' => '71.75',
            'lng' => '94.92',
            'region' => 'Красноярский край',
            'count' => 6000,
        ),
        'RU-LIP' => array(
            'lat' => '52.75',
            'lng' => '39.28',
            'region' => 'Липецкая обл',
            'count' => 1280,
        ),
        'RU-LEN' => array(
            'lat' => '60.03',
            'lng' => '30.50',
            'region' => 'Ленинградская обл',
            'count' => 1300,
        ),
        'RU-MOS' => array(
            'lat' => '55.75396',
            'lng' => '37.620393',
            'region' => 'Московская обл',
            'count' => 2500,
        ),
        'RU-MOW' => array(
            'lat' => '55.59',
            'lng' => '37.37',
            'region' => 'Москва г',
            'count' => 1000,
        ),
        'RU-MUR' => array(
            'lat' => '67.9',
            'lng' => '34.89',
            'region' => 'Мурманская обл',
            'count' => 256,
        ),
        'RU-RYA' => array(
            'lat' => '54.34',
            'lng' => '40.68',
            'region' => 'Рязанская обл',
            'count' => 1000,
        ),
        'RU-TVE' => array(
            'lat' => '57.28',
            'lng' => '34.53',
            'region' => 'Тверская обл',
            'count' => 2000,
        ),
		'RU-ROS' => array(
			'lat' => '47.222531',
			'lng' => '39.718705',
			'region' => 'Ростовская обл',
            'count' => 3000,
		),
        'RU-SPE' => array(
            'lat' => '60.03',
            'lng' => '30.50',
            'region' => 'Санкт-Петербург г',
            'count' => 400,
        ),
        'RU-AD' => array(
            'lat' => '44.512',
            'lng' => '39.792',
            'region' => 'Адыгея Респ',
            'count' => 600,
        ),
        'RU-TA' => array(
            'lat' => '55.360',
            'lng' => '50.801',
            'region' => 'Татарстан Респ',
            'count' => 2700,
        ),
        'RU-PNZ' => array(
            'lat' => '53.170',
            'lng' => '44.533',
            'region' => 'Пензенская обл',
            'count' => 1300,
        ),
        'RU-BA' => array(
            'lat' => '54.124',
            'lng' => '56.580',
            'region' => 'Башкортостан Респ' ,
            'count' => 2500,
        ),
        'RU-CHE' => array(
            'lat' => '54.444',
            'lng' => '60.535',
            'region' => 'Челябинская обл',
            'count' => 1500,
        ),
        'RU-VLA' => array(
            'lat' => '55.96',
            'lng' => '40.622',
            'region' => 'Владимирская обл',
            'count' => 1100,
        ),
        'RU-PER' => array(
            'lat' => '59.052',
            'lng' => '55.767',
            'region' => 'Пермский край',
            'count' => 1664,
        ),
        'RU-NVS' => array(
            'lat' => '55.342',
            'lng' => '80.156',
            'region' => 'Новосибирская обл',
            'count' => 1300,
        ),
        'RU-OMS' => array(
            'lat' => '56.19',
            'lng' => '73.411',
            'region' => 'Омская обл',
            'count' => 1000,
        ),
        'RU-IRK' => array(
            'lat' => '58.03',
            'lng' => '108.237',
            'region' => 'Иркутская обл',
            'count' => 1300,
        ),
        'RU-PRI' => array(
            'lat' => '45.41',
            'lng' => '134.91',
            'region' => 'Приморский край',
            'count' => 1664,
        ),
       'RU-ULY' => array(
            'lat' => '53.74',
            'lng' => '48.02',
            'region' => 'Ульяновская обл',
            'count' => 1200,
        ),
        'RU-VGG' => array(
            'lat' => '49.368',
            'lng' => '44.297',
            'region' => 'Волгоградская обл',
            'count' => 1500,
        ),
        'RU-VLG' => array(
            'lat' => '59.220492',
            'lng' => '39.891568',
            'region' => 'Вологодская обл',
            'count' => 5000,
        ),
        'RU-VOR' => array(
            'lat' => '50.85',
            'lng' => '40.54',
            'region' => 'Воронежская обл',
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
	// фильтр для поиска объектов в OSM [name~"Почт"]
    protected $filter = array(
        '[amenity=post_office]'
    );


	/** обновление данных по региону */
	public function update()
	{
		//запрашиваеем что-то недалеко от центра...
		$this->log('Update real data '.$this->region);
		//return;
		//$this->log( print_r(static::$urls, true));

        $maxcount = 4000;
        if (isset(static::$urls[$this->region]['count']))
            $maxcount = static::$urls[$this->region]['count'];

        $count = 64;
		$url = 'https://www.pochta.ru/portal-portlet/delegate/postoffice-api/method/offices.find.nearby.details?latitude='.static::$urls[$this->region]['lat'].'&longitude='.static::$urls[$this->region]['lng'].'&top='.$count.'&currentDateTime=2016-2-28T2%3A12%3A22&filter=ALL&hideTemporaryClosed=false&fullAddressOnly=true&searchRadius=10000&offset=';

		$offset = 0;
		while($offset < $maxcount)
		{
			$page = $this->download($url.$offset);
			$this->parse($page);
			$offset+= $count;
            //echo 'offset: '.$offset.' objects: '.count($this->objects)."\n";
		}
	}
	// парсер страницы
	protected function parse($st)
	{
		//$this->log($st);
        //echo $st;
		$a = json_decode($st, 1);
        if (!isset($a))
            return;

        //$this->log( print_r($a, true));
		foreach ($a as $obj)
        {
			//Если вылезли в соседние регионы
			if ($obj['region'] != static::$urls[$this->region]['region'])
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
		//
        //    //$obj['ref'] = sprintf("%d", $obj['Id']);
            $obj['ref'] = $obj['postalCode'];
			$obj['name'] = 'Отделение связи №'.$obj['ref'];

			//Телефон
			//[0] => Array
			//    (
			//        [phoneIsFax] => 
			//        [phoneNumber] => 53190
			//        [phoneTownCode] => 86393
			//        [phoneTypeName] => Начальник ОПС
			//    )
			//+7 863 2275943
			foreach ($obj['phones'] as $ph) {
				if (!isset($obj['contact:phone']))
					$obj['contact:phone'] = '';
                else
                    $obj['contact:phone'] .= ';';
				$obj['contact:phone'] .= '+7 '.((isset($ph['phoneTownCode']))?($ph['phoneTownCode'].' '):'').$ph['phoneNumber'];
			}

			//Режим работы
			//$time = array();
            if (isset($obj['workingHours'])) {
                 $time = '';
                foreach ($obj['workingHours'] as $wh) {
                    if ($time != '')
                        $time .= '; ';

                    if (!isset($wh['beginWorkTime']))    //Выходной?
                    {
                        $time .= str_replace(' - ', ' ', $wh['weekDayName']);
                        //$time .= $wh['weekDayName'];
                    }
                    else                                //рабочий день
                    {
                        //Вторник-пятница: 9:00-17:00 оставлем только дни.
                        $days = explode(': ', $wh['weekDayName']);
                        $time .= $days[0].' ';
                        //если есть обед....
                        if (isset($wh['lunches']) && (count($wh['lunches']) > 0))
                        {
                            $time .= substr($wh['beginWorkTime'], 0,5).'-'.substr($wh['lunches'][0]['beginLunchTime'], 0,5).',';
                            $time .= substr($wh['lunches'][0]['endLunchTime'], 0,5).'-'.substr($wh['endWorkTime'], 0,5);
                        }
                        else
                            $time .= substr($wh['beginWorkTime'], 0,5).'-'.substr($wh['endWorkTime'], 0,5);

                        //$item = str_replace(': ', ' ', $wh['weekDayName']);
                        //$time .= $item;
                    }
                }
                $obj['opening_hours'] = $this->time($time);
            }
            $obj['lat'] = $obj['latitude'];
            $obj['lon'] = $obj['longitude'];
		
            $this->addObject($this->makeObject($obj));
        }
	}
	/** сохранение страницы */
	//protected function savePage($url, $content)
	//{
	//	$md5 = $this->index;
	//	$fname = $_SERVER["DOCUMENT_ROOT"].'/_/_html/russian_post/'.$this->region.'/'.substr($md5, 0, 3);
	//	if (!file_exists($fname)) mkdir($fname, 0777, 1);
	//	$fname .= "/$md5.html";
	//
	//	if (strpos($content, '<body>') && !strpos($content, '<table'))
	//		$content = '-'; // сокращаем по-минимуму страницы без индекса
	//	if (!strpos($content, ' 404. ')) // страница не найдена
	//	if (!strpos($content, '<body onload="')) // кривая страница
	//	file_put_contents($fname, $content);
	//
	//	return $content;
	//}
	//protected function loadPage($url)
	//{
	//	$md5 = $this->index;
	//	$fname = $_SERVER["DOCUMENT_ROOT"].'/_/_html/russian_post/'.$this->region.'/'.substr($md5, 0, 3);
	//	$fname .= "/$md5.html";
	//
	//	$reload = 0;
	//	if (!file_exists($fname)) $reload = 1;
	//	else
	//	if (filesize($fname) < 10) return '-'; // такого индекса нет, и не будем заново проверять
	//	else
	//	if ($this->useCacheHtml) $reload = 0;
	//	else
	//	if (time() - filemtime($fname) < 3600*24*7) $reload = 0; // обновляли только что, поэтому больше не надо
	//	else if ($this->updateHtml || mt_rand(0,19) == 0)
	//		$reload = 1; // старые файлы обновляем с вероятностью 1/20
	//
	//	if ($reload) return false;
	//
	//	$page = file_get_contents($fname);
	//	if (strpos($page, '<body onload="')) return false; // страница переадресации
	//
	//	return $page;
	//}
}
	/** загрузка страницы */
