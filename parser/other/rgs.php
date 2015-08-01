<?php
require_once 'Validator.class.php';

class rgs extends Validator
{
	// откуда скачиваем данные
	protected $domain = 'http://www.rgs.ru';
	static $urls = array(
        'RU-MOW' => '/api/offices/getOffices.wbp?City=%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0&Region=%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0&District=&Street=&Metro=&Lat=55.75396&Lng=37.620393',
	);
	// поля объекта
	protected $fields = array(
        'office'           => 'insurance',
        'name'           => 'Росгосстрах',
        'official_name'        => '',
        //'contact:email'     => 'info@velobike.ru',
        'contact:phone'     => '',
        'contact:website'   => 'http://rgs.ru',
        'opening_hours'     => '',
        //'ref'               => '',
		'lat'               => '',
		'lon'               => '',
        '_addr'             => '',
		);

	// фильтр для поиска объектов в OSM
	protected $filter = array(
        '[office=insurance][name="Росгосстрах"]',
        );

	// парсер страницы
	protected function parse($st)
	{
        //echo $st;
		$a = json_decode($st, 1);
		
        foreach ($a['offices']['Data']['offices'] as $obj)
        {
            $obj['_addr'] = $obj['address'];

            //$obj['ref'] = $obj['id'];
            $obj['official_name'] = $obj['name'];
            unset($obj['name']);
            
			$time = $obj['time'];
			$time = preg_replace('/<b>.+/', '', $time);
			$time = preg_replace('/-?выходной/', ' off', $time);
			$time = preg_replace('/.+Обслуживание физических лиц.+?>/', '', $time);
			$time = preg_replace('/<br>/', '', $time);
            
            $obj['opening_hours'] = $this->time($time);
			$obj['opening_hours'] = preg_replace('/\s*[а-я].+$/ui', '$1', $obj['opening_hours']);
			$obj['opening_hours'] = preg_replace('/(.+(0|ff)).*/',  '$1', $obj['opening_hours']);
            //echo $obj['opening_hours'];

            //$obj['capacity'] = $obj['TotalPlaces'];
            
            $obj['lat'] = $obj['lat'];
            $obj['lon'] = $obj['lng'];


            $obj['contact:phone'] = '+7 '.$obj['phoneCode'].' '.$obj['phoneNumber'];
            
            $this->addObject($this->makeObject($obj));
        }
	}
}
