<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class lapy4 extends Validator
{
	protected $domain = 'https://4lapy.ru/_next/data/YwiOQeKXltNxOTYWP8jIX/shops.json';

	static $urls = [
		'RU-MOW' => '',
		'RU-MOS' => '',
		'RU-SPE' => '',
		'RU-VLA' => '',
		'RU-VGG' => '',
		'RU-VOR' => '',
		'RU-IVA' => '',
		'RU-KLU' => '',
		'RU-KOS' => '',
		'RU-LIP' => '',
		'RU-NIZ' => '',
		'RU-TUL' => '',
		'RU-ORL' => '',
		'RU-RYA' => '',
		'RU-TVE' => '',
		'RU-YAR' => '',
		'RU-TA'  => '',
		'RU'     => ''
	];

	/* Поля объекта */
	protected $fields = [
		'shop'            => 'pet',
		'ref'             => '',
		'name'            => 'Четыре лапы',
		'name:ru'         => 'Четыре лапы',
		'name:en'         => '',
		'contact:website' => 'https://4lapy.ru/',
		'contact:phone'   => '',
		'opening_hours'   => '',
		'pets'            => '',
		'aquarium'        => '',
		'veterinary'      => '',
		'grooming'        => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand:wikidata'  => '',
		'brand:wikipedia' => ''
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[shop=pet][name~"лапы",i]'
	];

	/* Обновление данных по региону */
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
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a['pageProps']['fallback']['/stores/stores?{"sort":"default","by":"desc","isActive":true}']['items'] as $obj) {
			$obj['name'] = 'Четыре лапы';
			$obj['ref'] = $obj['id'];

			// Координаты
			$obj['lat'] = $obj['coordinates']['lat'];
			$obj['lon'] = $obj['coordinates']['lon'];

			// Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			// Адрес
			$obj['_addr'] = $obj['address'];

			// Время работы
			$obj['opening_hours'] = $this->time($obj['schedule']);

			// Сервисы
			foreach ($obj['services'] as $service) {
				switch ($service['name']) {
					case 'Аквариумистика':
						$obj['aquarium'] = 'yes';
						break;
					case 'Вет. аптека':
						$obj['veterinary'] = 'yes';
						break;
					case 'animals':
						$obj['pets'] = 'yes';
						break;
					case 'gravirovka':
						//$obj['?'] = 'yes';
						break;
					case 'Груминг-салон':
						$obj['grooming'] = 'yes';
						break;
				}
			}

			$obj['contact:phone'] = $this->phone($obj['phone']) .'-'.$obj['additionalPhone'];

			$this->addObject($this->makeObject($obj));
		}
	}
}
