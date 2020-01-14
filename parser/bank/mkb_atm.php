<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class mkb_atm extends Validator
{
	protected $domain = 'https://old.mkb.ru/about_bank/address/poi_data/filials/';

	static $urls = [
		'RU'     => '',
		'RU-MOW' => '',
		'RU-MOS' => '',
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'atm',
		'ref'             => '',
		'name'            => 'МКБ',
		'name:ru'         => 'МКБ',
		'name:en'         => 'MKB',
		'official_name'   => '',
		'operator'        => 'ПАО "Московский кредитный банк"', // https://www.cbr.ru/credit/coinfo.asp?id=450000226
		'branch'          => '',
		'contact:website' => 'https://mkb.ru',
		'contact:phone'   => '+7 800 7755152',
		'currency:RUB'    => 'no',
		'currency:USD'    => 'no',
		'currency:EUR'    => 'no',
		'cash_in'         => 'no',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand'           => 'МКБ',
		'brand:ru'        => 'МКБ',
		'brand:en'        => 'MKB',
		'brand:wikipedia' => 'ru:Московский кредитный банк',
		'brand:wikidata'  => 'Q4304175'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=atm][name~"МКБ",i]'
	];

	/* Парсер страницы */
	protected function parse($st)
	{
		$xml = simplexml_load_string($st);
		$json = json_encode($xml);
		$array = json_decode($json, TRUE);

		foreach ($array['filial'] as $obj) {
			// Отсеиваем банкоматы
			if ($obj['types']['@attributes']['isatm'] != '1') {
				continue;
			}

			// Координаты
			$obj['lat'] = $obj['@attributes']['lat'];
			$obj['lon'] = $obj['@attributes']['lng'];

			// Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			// Идентификатор
			$obj['ref'] = $obj['@attributes']['id'];

			// Адрес
			$obj['_addr'] = $obj['address'];

			$obj['official_name'] = str_replace(['«','»', ], '"', $obj['name']);

			if (preg_match('/"(.+?)"/', $obj['official_name'], $m)) {
				$obj['branch'] = $m[1];
			}

			// Время работы
			$obj['opening_hours'] = $this->time($obj['workingtime']['interval']);

			// Контакты
			if (is_array($obj['phones']['phone'])) {
				$obj['contact:phone'] = $this->phone($obj['phones']['phone'][0]);
			} else {
				$obj['contact:phone'] = $this->phones($obj['phones']['phone'], ',');
			}

			// Валюты (выдача)
			if (is_array($obj['cur_out'])) {
				if (in_array('RUR', $obj['cur_out'])) $obj['currency:RUB'] = 'yes';
				if (in_array('RUB', $obj['cur_out'])) $obj['currency:RUB'] = 'yes';
				if (in_array('USD', $obj['cur_out'])) $obj['currency:USD'] = 'yes';
				if (in_array('EUR', $obj['cur_out'])) $obj['currency:EUR'] = 'yes';
			}
			if (is_array($obj['cur_in'] && isset($obj['cur_in']['cur']) && is_array($obj['cur_in']['cur']))) {
				if (in_array('RUR', $obj['cur_in']['cur'])) $obj['currency:RUB'] = 'yes';
				if (in_array('RUB', $obj['cur_in']['cur'])) $obj['currency:RUB'] = 'yes';
				if (in_array('USD', $obj['cur_in']['cur'])) $obj['currency:USD'] = 'yes';
				if (in_array('EUR', $obj['cur_in']['cur'])) $obj['currency:EUR'] = 'yes';
			}

			// Приём наличных
			if (!is_array($obj['is_cash_in']) && $obj['is_cash_in'] == 'Да') {
				$obj['cash_in'] = 'Да';
			}

			// Удаление поля
			unset($obj['name']);

			$this->addObject($this->makeObject($obj));
		}
	}
}
