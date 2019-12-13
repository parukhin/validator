<?php
/**
 * Функции для работы с OSM данными
 */
class OsmFunctions
{
	protected $osm_objects = [];
	private   $timestamp   = '';

	/* Обновление данных из базы OSM */
	public function update_osm()
	{
		$this->log("Request OAPI for ".$this->region." / ".implode(" ", $this->filter));
		$page = $this->query_overpass($this->region, $this->filter);

		if (isset($page)) {
			$this->log("Filter data ".$this->region." / ".implode(" ", $this->filter));
			$this->filter_objects($page);
		}
	}

	/* Запрос к Overpass API */
	private function query_overpass($region, $filters)
	{
		// TODO: сделать одну функцию для запросов к Overpass API
		$url = "https://overpass.openstreetmap.ru/api/interpreter";
		//$url = "https://overpass-api.de/api/interpreter";

		// Определение административной единицы
		if (strcasecmp($region, 'RU') == 0) {
			$admin_level = '2'; // страна
			$ref = 'ISO3166-1';
			$timeout = '300';
		} else {
			$admin_level = '4'; // субъект
			$ref = 'ref';
			$timeout = '180';
		}

		$query = "[out:json][timeout:$timeout]; ";

		$query .= "area['$ref'='$region'][admin_level=$admin_level][boundary=administrative]->.a; (";

		foreach ($filters as $filter)
		{
			$query .= "rel(area.a) $filter; >; ";
			$query .= "way(area.a) $filter; >; ";
			$query .= "node(area.a) $filter;";
		}

		$query .= "); out geom;";

		$page = $this->get_web_page($url.'?data='.urlencode($query));

		return $page;
	}

	/* Возвращает OSM объекты */
	public function get_objects_osm()
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

			$this->osm_objects[] = $item['tags'];
		} else
		if (strcmp($item['type'], 'way') === 0) {
			$item['tags']['id'] = 'w'.$item['id'];
			/* Вычисление центра объекта */
			$item['tags']['lat'] = ($item['bounds']['minlat'] + $item['bounds']['maxlat']) / 2;
			$item['tags']['lon'] = ($item['bounds']['minlon'] + $item['bounds']['maxlon']) / 2;

			$this->osm_objects[] = $item['tags'];
		} else
		if (strcmp($item['type'], 'relation') === 0) {
			$item['tags']['id'] = 'r'.$item['id'];
			/* Вычисление центра объекта */
			$item['tags']['lat'] = ($item['bounds']['minlat'] + $item['bounds']['maxlat']) / 2;
			$item['tags']['lon'] = ($item['bounds']['minlon'] + $item['bounds']['maxlon']) / 2;

			$this->osm_objects[] = $item['tags'];
		}
	}

	/* Get bbox from OverPass API */
	public function get_bbox($region)
	{
		$dir = $_SERVER["DOCUMENT_ROOT"].'/data';
		if (!file_exists($dir)) mkdir($dir);

		$fname = "$dir/bbox.json";

		if (file_exists($fname)) {

			$st = file_get_contents($fname);

			$a = json_decode($st, true);
			if (is_null($a)) {
				return null;
			}

			if (isset($a[$region])) {
				return $a[$region];
			}
		}

		// TODO: сделать одну функцию для запросов к Overpass API
		$url = "https://overpass.openstreetmap.ru/api/interpreter";
		//$url = "https://overpass-api.de/api/interpreter";

		// FIXME: запрос слишком много инфы загружает, поправить
		$query =
			'[out:json][timeout:180];
			rel[ref="'.$region.'"][admin_level=4][boundary=administrative];
			out bb;';

		$page = $this->get_web_page($url, $query);
		if (is_null($page)) {
			return null;
		}

		$page = json_decode($page, true);
		if (is_null($page)) {
			return null;
		}

		if (!$page) {
			$bbox = null;
		} else {
			$bbox = [
				'minlat' => $page['elements'][0]['bounds']['minlat'],
				'minlon' => $page['elements'][0]['bounds']['minlon'],
				'maxlat' => $page['elements'][0]['bounds']['maxlat'],
				'maxlon' => $page['elements'][0]['bounds']['maxlon'],
			];

			$a[$region] = $bbox;
			$st = json_encode($a);
			file_put_contents($fname, $st);
		}

		return $bbox;
	}

	/* Get geometry from OverPass API */
	public function get_geometry()
	{
		$region = $this->region;
		$dir = $_SERVER["DOCUMENT_ROOT"].'/data';
		if (!file_exists($dir)) mkdir($dir);

		$fname = "$dir/$region/geometry.json";

		if (file_exists($fname)) {

			$st = file_get_contents($fname);

			$polygons = json_decode($st, true);
			if (isset($polygons)) {
				return $polygons;
			}
		}

		// TODO: сделать одну функцию для запросов к Overpass API
		$url = "https://overpass.openstreetmap.ru/api/interpreter";
		//$url = "https://overpass-api.de/api/interpreter";

		// FIXME: запрос слишком много инфы загружает, поправить
		$query =
			'[out:json][timeout:180];
			rel[ref="'.$region.'"][admin_level=4][boundary=administrative];
			out geom;';

		$page = $this->get_web_page($url, $query);
		if (is_null($page)) {
			return null;
		}

		$page = json_decode($page, true);
		if (is_null($page)) {
			return null;
		}

		$polygons = [[]];
		$n = 0;

		foreach ($page['elements'][0]['members'] as $member) {
			if ($member['type'] == 'way') {
				$way = $member['geometry'];

				if (isset($polygons[$n][0])) {
					if ($way[0] == $polygons[$n][0]) {
						$polygons[$n] = array_reverse($polygons[$n]);
						array_shift($way);
					} else if ($way[0] == end($polygons[$n])) {
						array_shift($way);
					} else if (end($way) == $polygons[$n][0]) {
						$polygons[$n] = array_reverse($polygons[$n]);
						$way = array_reverse($way);
						array_shift($way);
					} else if (end($way) == end($polygons[$n])) {
						$way = array_reverse($way);
						array_shift($way);
					} else {
						$n++;
					}
				}

				foreach ($way as $node) {
					$polygons[$n][] = $node;
				}
			}
		}

		// Удаление последней точки
		foreach ($polygons as $i => $polygon) {
			if ($polygon[0] == end($polygon)) {
				array_pop($polygons[$i]);
				$this->log("Замкнутый полигон!");
			} else {
				$this->log("Незамкнутый полигон!");
			}
		}

		$st = json_encode($polygons);
		file_put_contents($fname, $st);

		$this->log("Загружена геометрия $region.");

		return $polygons;
	}

}
