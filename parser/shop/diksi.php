<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class diksi extends Validator
{
	protected $domain = 'https://dixy.ru';

	static $urls = [
		'RU-ARK' => '', // ушли
		'RU-BRY' => '',
		'RU-CHE' => '', // ушли
		'RU-IVA' => '',
		'RU-KLU' => '',
		'RU-KOS' => '',
		'RU-KR'  => '', // ушли
		'RU-LEN' => '',
		'RU-LIP' => '', // ушли
		'RU-MOS' => ['operator' => 'АО "Дикси ЮГ"'],
		'RU-MOW' => ['operator' => 'АО "Дикси ЮГ"'],
		'RU-MUR' => '', // ушли
		'RU-NGR' => '',
		'RU-NIZ' => '', // ушли
		'RU-ORL' => '',
		'RU-PSK' => '', // ушли
		'RU-RYA' => '',
		'RU-SMO' => '',
		'RU-SPE' => '',
		'RU-SVE' => '', // ушли
		'RU-TAM' => '', // ушли
		'RU-TUL' => '',
		'RU-TVE' => '',
		'RU-TYU' => '', // ушли
		'RU-VLA' => '',
		'RU-VLG' => '', // ушли
		'RU-YAR' => '',
		'RU' => ''
	];

	/* Поля объекта */
	protected $fields = [
		'shop'            => 'supermarket',
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
		'brand:wikidata'  => 'Q4161561',
		'brand:wikipedia' => 'ru:Дикси (сеть магазинов)'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[shop][name~"Дикси",i]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$url = "https://dixy.ru/ajax/stores-json.php";

		$page = $this->get_web_page($url);
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

		foreach ($a as $obj) {
			// Координаты
			$obj['lat'] = $obj['geometry']['coordinates'][0];
			$obj['lon'] = $obj['geometry']['coordinates'][1];

			// Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			if (isset($obj['properties']['balloonContentHeader'])) {
				$header = $obj['properties']['balloonContentHeader'];

				// Извлекаем только цифры из конца строки
				if (preg_match('/(\d+)\s*$/', $header, $matches)) {
					$obj['ref'] = $matches[1];
				}
			}

			// Сохраняем адрес
			if (isset($obj['properties']['balloonContentBody'])) {
				$obj['_addr'] = $obj['properties']['balloonContentBody'];
			}

			// Сохраняем время работы (если есть)
			if (isset($obj['properties']['balloonContentFooter'])) {
				$obj['opening_hours'] = $this->time($obj['properties']['balloonContentFooter']);
			}

			$this->addObject($this->makeObject($obj));
		}
	}
}
