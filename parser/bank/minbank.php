<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class minbank extends Validator
{
	protected $domain = 'https://www.minbank.ru/ajax/isic_address.php?acc_reserve_request=0&region_id=';

	// для банкоматов
	// https://telebank.minbank.ru/geoapi/getTerminals?region=%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0&class=1&lat=55.75396&lon=37.620393&count=10000&max_dist=1000000000

	static $urls = [
		'RU-MOW' => '20327'
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'bank',
		'ref'             => '',
		'name'            => 'Московский индустриальный банк',
		'name:ru'         => 'Московский индустриальный банк',
		'name:en'         => '',
		'official_name'   => '',
		'operator'        => 'ПАО "МИнБанк"',
		'branch'          => '',
		'contact:website' => 'https://www.minbank.ru', // https://www.cbr.ru/credit/coinfo.asp?id=450000741
		'contact:phone'   => '',
		'cash_in'         => '',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand:wikidata'  => '',
		'brand:wikipedia' => ''
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=bank][name~"индустриальный",i]'
	];

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}
		/*
		if (preg_match_all('/options = {.+?group\.add/s', $st, $m, PREG_SET_ORDER))
		foreach ($m as $item)
		if (preg_match('#'
			.'(?<lon>[\d\.]+), (?<lat>[\d\.]+)'
			.'.+?Адрес</b><br>(?<_addr>[^<]+)'
			.'(.+?работы</b><br>(?<hours>.+?)<)?'
			.'.+?s(?<type>\d)_group.add'
			.'#us', $item[0], $obj))
		{
			$is = mb_stripos($obj['_addr'], 'Москва') || mb_stripos($obj['_addr'], 'Зеленоград');
			if ($this->code == 'MOW' && !$is) continue;
			if ($this->code == 'MOS' &&  $is) continue;
			$is = mb_stripos($obj['_addr'], 'Петербург');
			if ($this->code == 'SPE' && !$is) continue;
			if ($this->code == 'LEN' &&  $is) continue;

			// 1 - банкомат
			// 2 - банкомат cash in
			// 6 - банкомат 24/7
			// 5 - банк
			if ($obj['type'] != 5) continue;

			$hours = $obj['hours'];
			$obj['opening_hours'] = $this->time($hours);
			$this->addObject($this->makeObject($obj));
		}
		*/
	}
}
