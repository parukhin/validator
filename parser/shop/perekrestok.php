<?php
require_once 'Validator.class.php';

class perekrestok extends Validator
{
	// откуда скачиваем данные
    protected $domain = 'http://www.perekrestok.ru';
	static $urls = array(
	    'RU-MOW' => array('410'    => '/api/shops/?city=$1'),
		'RU-MOS' => array('Московс'   => '/shops/moscow/#$1'),
		'RU-IVA' => array('Иваново'   => '/shops/moscow/#$1'),
		'RU-KLU' => array('Калуга'    => '/shops/moscow/#$1'),
		'RU-RYA' => array('Рязань'    => '/shops/moscow/#$1'),
		'RU-TVE' => array('Тверь'     => '/shops/moscow/#$1'),
		'RU-YAR' => array('Ярославль' => '/shops/moscow/#$1'),
		'RU-SPE' => array('Петерб'    => '/shops/northwest/#$1'),
		'RU-LEN' => array('Ленин'     => '/shops/northwest/#$1'),
		'RU-SAM' => array('Самара'    => '/shops/samara/#$1'),
		'RU-PNZ' => array('Пенза'     => '/shops/samara/#$1'),
		'RU-VOR' => array('Ворон'     => '/shops/cchernozem/#$1'),
		'RU-KUR' => array('Курск'     => '/shops/cchernozem/#$1'),
		'RU-LIP' => array('Липецк'    => '/shops/cchernozem/#$1'),
		'RU-TA'  => array('Казань'    => '/shops/kazan/#$1'),
		'RU-NIZ' => array('Ниж'       => '/shops/nnovgorod/#$1'),
	);
	// поля объекта
	protected $fields = array(
		'shop'     => 'supermarket',
		'name'     => 'Перекресток',
		'operator' => 'ЗАО ТД "Перекресток"',
		'website'  => 'http://www.perekrestok.ru',
		'opening_hours' => '',
		'phone'    => '',
		'lat'   => '',
		'lon'   => '',
		'_addr' => '',
		);

	// фильтр для поиска объектов в OSM
	protected $filter = array(
        '[shop=supermarket][name~"[пП]ерекр"]',
        );

	// парсер страницы
	protected function parse($st)
	{
        //echo $st;
		$a = json_decode($st, 1);
		foreach ($a as $obj)
            //if ($obj['cat_name'] == 'Офисы') // TODO: добавить банкоматы
        {
            //print_r($a);
            //print_r($obj);
            //echo $a[0];
            //echo $obj[0];
                // фильтруем только "наш" регион
                //if (!preg_match('/('.$this->code.')/', $obj['name'])) continue;

                // разделяем адрес и данные
                /*$obj['body'] = str_replace('&nbsp;', ' ', $obj['body']);
                //preg_match('/^(?<addr>.{10,}?)(?<data><.+)/s', $obj['body'], $d);
                //$obj['_data'] = preg_replace('/<.+?>/', ' ', $d['data']);
                */
                // адрес
                //$obj['_addr'] = strip_tags($d['addr']);
                //if (!strpos($obj['_addr'], $obj['name']))
                //    $obj['_addr'] = 'г. '.$obj['name'].', '.$obj['_addr'];
            $obj['_addr'] = strip_tags($obj['address']);

                // телефон
                //if (preg_match('#\([\d\) -]+#', $obj['_data'], $m))
            $obj['phone'] = $this->phone($obj['tel']);

            //врея работы
            if ($obj['time']['is_24'] == 1)
                $hours = '24/7';
            else
                $hours = $obj['time']['open'].'-'.$obj['time']['close'];
            $obj['opening_hours'] = $this->time($hours);

            if ($obj['is_green'] == 1)
                $obj['name'] = 'Зеленый Перекресток';

                


                // номер отделения
                //if (0
                //    || preg_match('/№\s*(\d+)/', $obj['_data'], $m)
                //    || preg_match('/№\s*(\d+)/', $obj['title'], $m)
                //) $obj['ref'] = $m[1];

            list($obj['lat'], $obj['lon']) = explode(',', $obj['coordinates']);

                //unset($obj['name']); // стираем неправильное название

                $this->addObject($this->makeObject($obj));
        }
        /*
		if (preg_replace_callback('#citytitle">(?<city>.+?)<(?<list>.+?worktime.+?)\n</table>#s', function($x)
		{
			if (!mb_strpos(' '.$x['city'], $this->code)) return; // фильтруем не наш регион

			$this->city = $x['city'];

			if (preg_match_all('#'
				.'worktime.+?td>(?<time>[^<]+)<'
				.'(.+?location">(?<place>[^<]+)<)?'
				.'.+?tel">(?<phone>.+?)<'
				.'.+?address">(?<_addr>.+?)<'
				.'#s', $x['list'], $m, PREG_SET_ORDER))
			foreach ($m as $obj)
			{
				$hours = $obj['time'];
				if (preg_match('/24.*час/', $hours)) $hours = '24/7';
				else $hours = preg_replace('/^(\d):/', '0$1:',
					str_replace(
						array('.', ' ', '—', '&mdash;'),
						array(':', '',  '-', '-'),
						$hours
					)
				);
				$obj['opening_hours'] = $this->time($hours);
				$obj['phone'] = $this->phone($obj['phone']);

				if (mb_strpos(' '.$obj['place'], 'м. ')) // есть метро
				$obj['_addr'] = $this->city.', '.$obj['_addr'];
				else
				$obj['_addr'] = $obj['place'].', '.$obj['_addr']; // добавляем город к адресу

				$this->addObject($this->makeObject($obj));
			}

		}, $st));
        */
	}
}
