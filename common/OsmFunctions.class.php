<?php
/**
 * Функции для работы с OSM данными
 */
class OsmFunctions
{
	protected $osm_objects = [];
	private   $timestamp   = '';

	/* Загрузка данных из базы OSM */
	public function loadOSM()
	{
		$this->log("Request OAPI for ".$this->region." / ".implode(" ", $this->filter));
		$page = $this->updateOverPass($this->region, $this->filter);

		if (isset($page)) {
			$this->log("Filter data ".$this->region." / ".implode(" ", $this->filter));
			$this->filter_objects($page);
		}
	}

	/* Запрос к Overpass API */
	private function updateOverPass($region, $filters)
	{
		// TODO: сделать одну функцию для запросов к Overpass API
		//$url = "http://overpass.osm.rambler.ru/cgi/interpreter"; // плохо ищет без учёта регистра (либо вообще не ищет??), например, '[shop][name~"Азбука Вкуса",i]'
		$url = "http://www.overpass-api.de/api/interpreter";

		if (strcasecmp($region, 'RU') == 0) { // определяем административную единицу
			$admin_level = '2'; // страна
			$ref = 'ISO3166-1';
			$timeout = '300';
		} else {
			$admin_level = '4'; // субъект
			$ref = 'ref';
			$timeout = '180';
		}

		$query = "data=[out:json][timeout:$timeout]; ";

		$query .= "area['$ref'='$region'][admin_level=$admin_level][boundary=administrative]->.a; (";

		foreach ($filters as $filter)
		{
			$query .= "rel (area.a) $filter; >; ";
			$query .= "way (area.a) $filter; >; ";
			$query .= "node (area.a) $filter;";
		}

		$query .= "); out geom;";

		$page = $this->get_web_page($url, $query);

		return $page;
	}

	/* Возвращает OSM объекты */
	public function getOSMObjects()
	{
		return $this->osm_objects;
	}

	/* Возвращает время обновления базы OSM */
	public function get_timestamp()
	{
		return $this->timestamp;
	}

	/* Отфильтровывает объекты */
	private function filter_objects($st)
	{
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		$this->osm_objects = [];
		$this->timestamp = $a['osm3s']['timestamp_osm_base'];

		foreach ($a['elements'] as $item) {
			if (substr_count($st, $item['id']) > 1) { // если точка или линия являются частью чего-либо (встречаются более 2 раз)
				// FIXME: возможно совпадение по id у объектов разных типов
				continue; // пропускаем
			}
			$this->add_object($item);
		}
	}

	/* Добавляет объект в массив */
	private function add_object($item)
	{
		if (strcmp($item['type'], 'node') === 0) {
			$item['tags']['id'] = 'n'.$item['id'];
			$item['tags']['lat'] = $item['lat'];
			$item['tags']['lon'] = $item['lon'];

			array_push($this->osm_objects, $item['tags']);
		} else
		if (strcmp($item['type'], 'way') === 0) {
			$item['tags']['id'] = 'w'.$item['id'];
			/* Вычисление центра объекта */
			$item['tags']['lat'] = ($item['bounds']['minlat'] + $item['bounds']['maxlat']) / 2;
			$item['tags']['lon'] = ($item['bounds']['minlon'] + $item['bounds']['maxlon']) / 2;

			array_push($this->osm_objects, $item['tags']);
		} else
		if (strcmp($item['type'], 'relation') === 0) {
			$item['tags']['id'] = 'r'.$item['id'];
			/* Вычисление центра объекта */
			$item['tags']['lat'] = ($item['bounds']['minlat'] + $item['bounds']['maxlat']) / 2;
			$item['tags']['lon'] = ($item['bounds']['minlon'] + $item['bounds']['maxlon']) / 2;

			array_push($this->osm_objects, $item['tags']);
		}
	}

	/* Get bbox from OverPass API */
	public function getbbox($region)
	{
		$url = "http://overpass.osm.rambler.ru/cgi/interpreter";
		//$url = "http://www.overpass-api.de/api/interpreter";

		// FIXME: запрос слишком много инфы загружает, поправить
		$query =
			'[out:json][timeout:180];
			rel[ref="'.$region.'"][admin_level=4][boundary=administrative];
			out bb;';

		$page = $this->get_web_page($url, $query);
		if (is_null($page)) {
			return NULL;
		}

		//$page = "{ 'bar': 'baz' }"; // ломаем json для проверки
		$page = json_decode($page, true);
		if (is_null($page)) {
			return NULL;
		}

		if (!$page) {
			$bbox = [];
		} else {
			$bbox = [
			'minlat' => $page['elements'][0]['bounds']['minlat'],
			'minlon' => $page['elements'][0]['bounds']['minlon'],
			'maxlat' => $page['elements'][0]['bounds']['maxlat'],
			'maxlon' => $page['elements'][0]['bounds']['maxlon'],
			];
		}

		return $bbox;
	}

	/* Возвращает адрес по координатам */
	public function getAddressByCoords($lat, $lon)
	{
		// TODO: сделать функцию для проверки соотвествия координат выбранному региону
		$url = "http://nominatim.openstreetmap.org/reverse?format=json&lat=$lat&lon=$lon";

		$page = $this->get_web_page($url);
		if (is_null($page)) {
			return NULL;
		}

		$page = json_decode($page, true);
		if (is_null($page)) {
			return NULL;
		}

		if (isset($page['address']['state'])) {
			$state = $page['address']['state'];
		} else {
			$state = NULL;
		}

		return $state;
	}
}
