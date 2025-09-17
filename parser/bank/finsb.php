<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class finsb extends Validator
{
	protected $domain = 'https://www.finsb.ru/api/about/offices/?city=4808&offices=true&atm=false&atmCashAccepting=false&atmAllDay=false&atmEveryday=false';

	static $urls = [
		'RU'     => '',
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'bank',
		'ref'             => '',
		'name'            => 'Финсервис',
		'name:ru'         => 'Финсервис',
		'official_name'   => '',
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
		'[amenity=bank][name~"Финсервис",i]'
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

			// Идентификатор
			// $obj['ref'] = $obj['Biskvit_id'];

			// Адрес
			$obj['_addr'] = $obj['address'];

			$obj['branch'] =  $obj['title'];

			// Доступность для инвалидных колясок
			if (!is_null($obj['special']['ramp'])) { $obj['wheelchair'] = ($obj['special']['ramp'] == '1') ? 'yes' : 'no';
			};

			// Время работы
			$obj['opening_hours'] = $this->time($obj['workingMode']);

			// Телефоны +7 495 7777787
			$obj['contact:phone'] = $this->phone($obj['phones'][0]);

			$this->addObject($this->makeObject($obj));
		}
	}
}
