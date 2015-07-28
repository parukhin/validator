<?php
require_once 'Validator.class.php';

class velobike extends Validator
{
	// откуда скачиваем данные
	protected $domain = 'http://velobike.ru';
	static $urls = array(
		'RU-MOW' => '/proxy/parkings',
	);
	// поля объекта
	protected $fields = array(
        'network'           => 'Велобайк',
        'amenity'           => 'bicycle_rental',
        'capacity'          => '',
        'contact:email'     => 'info@velobike.ru',
        'contact:phone'     => '+7 495 9568286',
        'contact:website'   => 'http://velobike.ru',
        'operator'          => 'ЗАО "СитиБайк"',
        'ref'               => '',
		'lat'               => '',
		'lon'               => '',
        '_addr'             => '',
		);

	// фильтр для поиска объектов в OSM
	protected $filter = array(
        '[amenity=bicycle_rental][network="Велобайк"]',
        );

	// парсер страницы
	protected function parse($st)
	{
        //echo $st;
		$a = json_decode($st, 1);
		foreach ($a['Items'] as $obj)
        {
            $obj['_addr'] = substr($obj['Address'], 6);    

            $obj['ref'] = sprintf("%d", $obj['Id']);
            $obj['capacity'] = $obj['TotalPlaces'];
            
            $obj['lat'] = $obj['Position']['Lat'];
            $obj['lon'] = $obj['Position']['Lon'];

            $this->addObject($this->makeObject($obj));
        }
	}
}
