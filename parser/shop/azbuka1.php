<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class azbuka1 extends Validator
{
	protected $domain = 'https://av.ru/shops/shop_list_json/';

	static $urls = [
		'RU-MOW' => ['id' => '1055'],
		'RU-MOS' => ['id' => '1055'],
		'RU-SPE' => ['id' => '1056'],
		'RU'     => []
	];

	/* Поля объекта */
	protected $fields = [
		'shop'            => '',
		'name'            => '',
		'name:ru'         => '',
		'name:en'         => '',
		'operator'        => 'ООО "Городской супермаркет"',
		'contact:phone'   => '+7 495 5043478',
		'contact:website' => 'https://av.ru',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand:wikidata'  => '',
		'brand:wikipedia' => ''
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[shop][name~"Азбука Вкуса",i]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$page = $this->get_web_page($this->domain);
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

		foreach ($a['shop_list'] as $obj) {
			// Координаты
			$obj['lat'] = $obj['coords'][0];
			$obj['lon'] = $obj['coords'][1];

			// Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			//$obj['convenience_shop'] // ??, видимо, тоже самое что и round_the_clock

			// Формат магазина: Азбука Вкуса, АВ Daily, АВ Энотека и АВ Маркет
			if ($obj['shop_type'] != '3344710') { // Азбука Вкуса
				continue;
			}

			$obj['name'] = 'Азбука Вкуса';
			$obj['name:ru'] = 'Азбука Вкуса';
			$obj['name:en'] = 'Azbuka Vkusa';
			$obj['shop'] = 'supermarket';

			// Адрес
			$obj['_addr'] = $obj['title'];

			// Время работы
			if ($obj['props']['round_the_clock'] == 1) {
				$obj['opening_hours'] = '24/7';
			} else {
				$page = $this->get_web_page('https://av.ru'.$obj['link']);
				if (is_null($page)) {
					return;
				}

				preg_match_all('#'
				.'.<div class="block_graphic mb20 fs15">(?<hours>.+?)</div>'
				.'#us', $page, $m, PREG_SET_ORDER);

				if (isset($m[0]['hours'])) {
					$m[0]['hours'] = str_replace('Режим работы:', '',          $m[0]['hours']);
					$m[0]['hours'] = str_replace('В будни',       'Mo-Fr',     $m[0]['hours']);
					$m[0]['hours'] = str_replace('по выходным',   'Sa-Su',     $m[0]['hours']);
					$m[0]['hours'] = str_replace(',',             ';',         $m[0]['hours']);

					$obj['opening_hours'] = $this->time($m[0]['hours']);
				} else {
					$this->log('Не удалось определить время работы в магазине по адресу: '.$obj['title']);
				}
			}

			$this->addObject($this->makeObject($obj));
		}
	}
}
