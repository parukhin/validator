<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class finsb_atm extends Validator
{
	protected $domain = 'https://www.finsb.ru/api/about/offices/?city=4808&offices=false&atm=true&atmCashAccepting=false&atmAllDay=false&atmEveryday=false';

	static $urls = [
		'RU'     => '',
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'atm',
		'ref'             => '',
		'operator'        => 'АО "Банк Финсервис"', // https://www.cbr.ru/banking_sector/credit/coinfo/?id=450039653
		'branch'          => '',
		'contact:website' => 'https://www.finsb.ru/',
		'contact:phone'   => '',
		'wheelchair'      => '',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand'           => 'Финсервис',
		'brand:wikidata'  => 'Q21644992'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=atm][operator~"Финсервис",i]'
	];

	public function update()
	{
		$url = $this->domain;

		$page = $this->get_web_page($url);
		if (is_null($page)) {
			return;
		}
		$this->parse($page);
	}

	/* Парсер страницы */
	protected function parse($st)
	{
		$st = json_decode($st, true);
		if (is_null($st)) {
			return;
		}

		foreach ($st['items'] as $obj) {
			// Координаты
			$obj['lat'] = $obj['coordinates']['0'];
			$obj['lon'] = $obj['coordinates']['1'];

			// Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			// Адрес
			$obj['_addr'] = $obj['address'];

			// Время работы
			$obj['opening_hours'] = $this->time($obj['workingMode']);

			$this->addObject($this->makeObject($obj));
		}
	}
}
