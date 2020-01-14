<?php
require_once '../parser/cafe/rosinter.php';

class planetasushi extends rosinter
{
	// поля объекта
	protected $fields = array(
		'amenity'  => 'cafe',
		'name'     => 'Планета Суши',
		'contact:website' => 'https://planetsushi.ru',
		'contact:phone'   => '',
		'opening_hours'   => '',
		'lat'   => '',
		'lon'   => '',
		'_addr' => '',
		);
	// фильтр для поиска объектов в OSM
    protected $filter = array(
        '[amenity=cafe][name~"ланета"]'
    );

}
