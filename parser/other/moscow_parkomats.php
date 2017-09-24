<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class moscow_parkomats extends Validator
{
	protected $domain = 'https://op.mos.ru/EHDWSREST/catalog/export/get?id=90806';

	static $urls = [
		'RU-MOW' => ''
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'              => 'vending_machine',
		'vending'              => 'parking_tickets',
		'zone:parking'         => '',
		'ref'                  => '',
		'ref:mos_parking'      => '',
		'operator'             => 'ГКУ «Администратор Московского парковочного пространства»',
		'contact:website'      => 'http://parking.mos.ru/',
		'contact:phone'        => '+7 495 539-54-54',
		'opening_hours'        => '24/7',
		'payment:cash'         => 'no',
		'payment:credit_cards' => 'yes',
		'payment:debit_cards'  => 'yes',
		'lat'                  => '',
		'lon'                  => '',
		'_addr'                => '',
		'operator:wikidata'             => '',
		'operator:wikipedia'            => ''
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=vending_machine]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$this->log('Обновление данных по региону '.$this->region.'.');

		$url = $this->domain;
		$dir = $_SERVER["DOCUMENT_ROOT"].'/data/RU-MOW';

		$archive = $this->get_web_page($url);
		if (is_null($archive)) {
			return;
		}

		file_put_contents("$dir/moscow_parkomats.zip", $archive);

		$zip = new ZipArchive;

		if ($zip->open("$dir/moscow_parkomats.zip") === true) {
			$zip->extractTo($dir);
			$filename = $zip->getNameIndex(0);
			$zip->close();
		} else {
			return;
		}

		$page = file_get_contents("$dir/$filename");
		$page = mb_convert_encoding($page, 'utf8', 'cp1251');

		unlink("$dir/$filename");
		unlink("$dir/moscow_parkomats.zip");

		$this->parse($page);
	}

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a as $obj) {

			// Координаты
			$obj['lat'] = $obj['geoData']['coordinates'][1];
			$obj['lon'] = $obj['geoData']['coordinates'][0];

			$obj['zone:parking'] = $obj['ParkingZoneNumber'];
			$obj['ref'] = str_replace('Паркомат № ', '', $obj['NumberOfParkingMeter']);
			$obj['ref:mos_parking'] = $obj['global_id'];

			$obj['_addr'] = $obj['AdmArea'].', '.$obj['Location'];

			$this->addObject($this->makeObject($obj));
		}
	}
}
