<?php
class Geocoder
{
	private $context = null;

	public function __construct()
	{
		$this->context = stream_context_create(
			array('http' => array(
				'method'  => 'GET',
				'timeout' => 3,
				'header'  => "User-agent: OSM geocoder https://osm.cupivan.ru\r\n"
			))
		);
	}

	/* Геокодирование адреса */
	public function getCoordsByAddress($st)
	{
		$st = preg_replace('/ /',   ' ', $st);
		$st = preg_replace('/([\.,;])(\S)/u', '$1 $2', $st); // после знака препинания пробел, а то глюки

		$st = str_replace([' пр-т', ' пр.', ' ул.', ' пл.', ' пер.'],
			[' проспект', ' проспект', ' улица', ' площадь', ' переулок'], $st);
		$st = str_replace([' с.', ' п.', ' пос.', ' р-н'],
			[' село', ' поселок', ' поселок', ' район'], $st);
		$st = str_replace(['Республика', 'дом', 'д.', ' г.'],
			[' ', ' ', ' ', ' '], $st);

		if (strpos($st, 'улица') === false)
			$st = str_replace(' ул', ' улица', $st);

		$st = preg_replace('/\s+/', ' ', $st);
		$res = $this->geocode($st);

		if (!isset($res['matches'][0]['lat'])) return array();
		$res = array_intersect_key($res['matches'][0], array('lat'=>0, 'lon'=>0));

		return $res;
	}

	/* Геокодирование */
	private function geocode($st)
	{
		$res = $this->load($st);
		if ($res) return $res;
		$url = 'https://openstreetmap.ru/api/autocomplete?q='.urlencode($st);
		$res = @file_get_contents($url.'&email=cupivan@narod.ru&from=validator', false, $this->context);
		if (!$res) { echo "Error geocode: $st\n"; return false; }

		$res = json_decode($res, true);
		$this->save($st, $res);

		return $res;
	}

	/* Выдача закешированного значения */
	private function load($st)
	{
		$fname = $this->getFileName($st);
		if (file_exists($fname) && time() - filemtime($fname) < 7*24*3600)
			return unserialize(file_get_contents($fname));
		return false;
	}

	/* Сохранение значения в кеше */
	private function save($st, $value)
	{
		$fname = $this->getFileName($st);
		$dir = preg_replace('#[^/]+$#', '', $fname);
		if (!file_exists($dir)) mkdir($dir, 0777, true);
		return file_put_contents($fname, serialize($value));
	}

	/* Имя файла на основе запроса */
	private function getFileName($st)
	{
		$md5 = md5($st);
		$folder = '';

		if (preg_match('/([а-я]+)\s+обл/ui', $st, $m)) $folder = $m[1];
		if (preg_match('/((г|д|дер|пос|с|п|пгт|т)\.\s*|(станица|хутор|село|аул)\s+)([а-я]{2,})/ui',  $st, $m)) $folder = $m[4];

		if ($folder)
		{
			$folder = mb_convert_case($folder, MB_CASE_TITLE, 'utf-8');
			$folder = mb_substr($folder, 0, 1).'/'.mb_substr($folder, 0, 2)."/$folder";
		}
		else
			$folder = '_/'.substr($md5, 0, 2);

		return $_SERVER["DOCUMENT_ROOT"].'/_/_geocoder/'.$folder."/$md5.sz";

	}

	/* Обратное геокодиорование */
	public function getAddressByCoords($lat, $lon)
	{
		$url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=$lat&lon=$lon";

		$page = $this->get_web_page($url);
		if (is_null($page)) {
			return null;
		}

		$page = json_decode($page, true);
		if (is_null($page)) {
			return null;
		}

		if (isset($page['address']['state'])) {
			$state = $page['address']['state'];
		} else {
			$state = null;
		}

		return $state;
	}

	/* Проверка нахождение точки внутри полигона */
	public function pointInPolygon($lat, $lon, $polygon)
	{
		$c = 0;
		$npol = count($polygon);

		for ($i = 0, $j = $npol - 1; $i < $npol; $j = $i++) {
			if (((($polygon[$i]['lon'] <= $lon) && ($lon < $polygon[$j]['lon'])) || (($polygon[$j]['lon'] <= $lon) && ($lon < $polygon[$i]['lon'])))
			&& ($lat > (($polygon[$j]['lat'] - $polygon[$i]['lat']) * ($lon - $polygon[$i]['lon']) / ($polygon[$j]['lon'] - $polygon[$i]['lon']) + $polygon[$i]['lat'])))
				$c = !$c;
		}

		return $c;
	}
}
