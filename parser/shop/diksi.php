<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class diksi extends Validator
{
	protected $domain = 'https://dixy.ru';

	static $urls = [
		'RU-MOW' => '',
		'RU-MOS' => '',
		'RU-SPE' => '',
		'RU-LEN' => '',
		'RU-ARK' => '',
		'RU-KR'  => '',
		'RU-VLG' => '',
		'RU-PSK' => '',
		'RU-NGR' => '',
		'RU-MUR' => '',
		'RU-TUL' => '',
		'RU-BRY' => '',
		'RU-KLU' => '',
		'RU-SMO' => '',
		'RU-RYA' => '',
		'RU-ORL' => '',
		'RU-TAM' => '',
		'RU-LIP' => '',
		'RU-VLA' => '',
		'RU-IVA' => '',
		'RU-KOS' => '',
		'RU-YAR' => '',
		'RU-NIZ' => '',
		'RU-CHE' => '',
		'RU-SVE' => '',
		'RU-TYU' => '',
		'RU-TVE' => ''
	];

	/* Поля объекта */
	protected $fields = [
		'shop'            => 'convenience',
		'ref'             => '',
		'name'            => 'Дикси',
		'name:ru'         => 'Дикси',
		'name:en'         => 'Dixy',
		'operator'        => '',
		'contact:website' => 'https://dixy.ru',
		'contact:phone'   => '',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'wikidata'        => '',
		'wikipedia'       => 'ru:Дикси_(сеть_магазинов)'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[shop][name~"Дикси",i]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$this->log('Обновление данных по региону '.$this->region.'.');

		$url = "https://dixy.ru/local/ajax/requests/nearest_shop_get_placemarks.php";
		$query = "request_mode=ajax&site_id=s1";

		$page = $this->get_web_page($url, $query);
		if (is_null($page)) {
			return;
		}

		$this->parse($page);
	}

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a['features'] as $obj) {
			$obj['ref'] = $obj['id'];

			// Координаты
			$obj['lat'] = $obj['geometry']['coordinates'][0];
			$obj['lon'] = $obj['geometry']['coordinates'][1];

			// Отсеиваем по региону
			if (!$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			//"<div class="dixy_placemark_baloon_content">ул.Мира д.2/18<br>09:00-22:00</div>"

			if (preg_match_all('#.+?>(?<address>.+?)<.+?>(?<hours>.+?)<#s', $obj['properties']['balloonContent'], $m, PREG_SET_ORDER)) {
				$obj['_addr'] = $m[0]['address'];
				$obj['opening_hours'] = $this->time($m[0]['hours']);
			}

			$this->addObject($this->makeObject($obj));
		}
	}
}
