<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class mkb extends Validator
{
	protected $domain = 'http://mkb.ru/about_bank/address/poi_data/filials/';

	static $urls = [
		'RU-MOW' => '',
		'RU-MOS' => '',
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'bank',
		'ref'             => '',
		'name'            => 'МКБ',
		'name:ru'         => 'МКБ',
		'name:en'         => 'MKB',
		'official_name'   => '',
		'department'      => '',
		'operator'        => 'ПАО "Московский кредитный банк"', // https://www.cbr.ru/credit/coinfo.asp?id=450000226
		'branch'          => '',
		'contact:website' => 'http://mkb.ru',
		'contact:phone'   => '',
		'wheelchair'      => '',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'operator:wikipedia'       => '',
		'operator:wikidata'        => 'ru:Московский_кредитный_банк'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=bank][name~"МКБ",i]'
	];

	/* Парсер страницы */
	protected function parse($st)
	{
		$xml = simplexml_load_string($st);
		$array = $this->xmlToArray($xml);

		foreach ($array['filials']['filial'] as $obj) {
			// Отсеиваем не отделения
			if (!is_array($obj['model'])) {
				continue;
			}

			// Отсеиваем оперкассы
			if (strripos($obj['name'], 'Оперкасса') !== false) {
				continue;
			}

			// Координаты
			$obj['lat'] = $obj['@lat'];
			$obj['lon'] = $obj['@lng'];

			// Отсеиваем по региону
			if (!$this->isInRegionByCoordsFromSputnik($obj['lat'], $obj['lon'])) {
				continue;
			}

			$obj['ref'] = $obj['@id'];

			// Адрес
			$obj['_addr'] = $obj['address'];

			$obj['official_name'] = str_replace(['«','»', ], '"', $obj['name']);
			$obj['name'] = 'МКБ';

			if (preg_match('/"(.+?)"/', $obj['official_name'], $m)) {
				$obj['department'] = $m[1];
			}

			// Время работы
			$obj['opening_hours'] = $this->time($obj['workingtime']['interval']);

			// Контакты
			if (is_array($obj['phones']['phone'])) {
				$obj['contact:phone'] = $this->phone($obj['phones']['phone'][0]);
			} else {
				$obj['contact:phone'] = $this->phones($obj['phones']['phone'], ',');
			}

			$this->addObject($this->makeObject($obj));
		}
	}
}
