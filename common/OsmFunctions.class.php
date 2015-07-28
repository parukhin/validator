<?php
/**
 * Функции для работы с OSM данными
 */
class OsmFunctions
{
	protected $osm_objects = array();
	private   $timestamp   = '';

	/** загрузка данных OSM */
	public function loadOSM()
	{
		$this->log("Request OAPI for ".$this->region." / ".implode(" ", $this->filter));
        
        $page = $this->updateOverPass($this->region, $this->filter);
        if ($page != '')    //$this->log("failed request");
		    $this->filterOsm($page, ''); //@$this->filter[1]
	}
    private function searchCondition($filter)
    {
        //return '[shop=supermarket][name="Дикси"]';
        return $filter[0];
        //return implode("", $filter);
        //$condition = '';
        //$condition = $condition."[".$filter[0]."]";
        //$condition = $condition."[name~"."\"".$filter[1]."\""."]";
        //return $condition;
        //$type  = explode('=', preg_replace('/[^=]+?,/', '', $this->filter[0]));
		//$type  = ($type[0] == 'place') ? $type[0] : $type[1];
    }

    private function updateOverPass($region, $filter)
    {
        $condition = $this->searchCondition($filter);

        $queryUrl = "http://overpass.osm.rambler.ru/cgi/interpreter";
        $queryParam = "data=[out:xml] [timeout:60];";
        $queryParam = $queryParam."area [\"addr:country\"=\"RU\"] [\"admin_level\"=\"4\"] [\"iso3166-2\"=\"".$region."\"]->.a; ";
        $queryParam = $queryParam."( ";
        //$queryParam = $queryParam."relation (area.a) ";
        //$queryParam = $queryParam.$condition;
        ////$queryParam = $queryParam."; >; ";
        //$queryParam = $queryParam."; ";

        foreach ($filter as $value)
        {
            $queryParam = $queryParam."way (area.a) ";
            $queryParam = $queryParam.$condition;
            //$queryParam = $queryParam.";>";
            $queryParam = $queryParam."; ";
        }

        foreach ($filter as $value)
        {
            $queryParam = $queryParam."node (area.a) ";
            $queryParam = $queryParam.$value;
            //$queryParam = $queryParam.";>";
            $queryParam = $queryParam."; ";
        }
        


        $queryParam = $queryParam.");  ";
        $queryParam = $queryParam."out meta;";

        //$this->log($queryParam);

        //$uri = $queryUrl.$queryParam;
        //error_reporting(E_ALL);
        //echo $uri;
        //$page = @file_get_contents($queryUrl.$queryParam, false, $this->context);
        $context = stream_context_create(array(
          'http' => array(
              'method' => 'POST',
              'header' => 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL,
              'content' => $queryParam,
          ),
        ));

        $page = @file_get_contents($queryUrl, false, $context);
        //echo $page;
        if (!$page)
        {
            $this->log("Error download: $queryUrl.$queryParam\n");
            return;
        }
        //$this->response = $http_response_header; // заголовки ответа
        //if (stripos($page.implode('', $this->response), 'windows-1251'))
        //    $page = iconv('cp1251', 'utf-8', $page);

        //if (!$force)
        //    $page = $this->savePage($url, $page);

        return $page;
    }
	/** OSM объекты */
	public function getOSMObjects()
	{
		return $this->osm_objects;
	}
	/** самый "свежий" объект */
	public function getNewestTimestamp()
	{
		return $this->timestamp;
	}
	/** загрузка и фильтрация объектов */
	//private function filterOsm($fname, $filter='')
	//{
	//	// загружаем объекты и отфильтровываем нужные
	//	$xml = file_get_contents($fname);
	//	if (!$xml) return;
    private function filterOsm($src, $filter='')
    {
        //echo $src;
		$xml = new SimpleXMLElement($src);
		$this->osm_objects = array();
		mb_internal_encoding('utf-8');
		$this->timestamp = '';
		foreach ($xml->node as $v) $this->testObject($v, 'n', $filter);
		foreach ($xml->way  as $v) $this->testObject($v, 'w', $filter);
		foreach ($xml->relation as $v) $this->testObject($v, 'r', $filter);
	}
	/** попадает ли объект в фильтр? */
	private function testObject($item, $type, $filter='')
	{
		$a = array();
		foreach ($item->attributes() as $k => $v) $a[$k] = (string)$v;
		foreach ($item->tag as $tag) $a[(string)$tag->attributes()['k']] = (string)$tag->attributes()['v'];
		$a['id'] = $type.$a['id'];

		// опеделяем самую свежую правку
		if ($this->timestamp < $a['timestamp']) $this->timestamp = $a['timestamp'];

		// убираем ненужные теги
		unset($a['version']);
		unset($a['timestamp']);
		unset($a['uid']);
		unset($a['user']);

		// фильтруем
		$ok = $filter ? 0 : 1;
		if (!$ok)
		foreach ($a as $v)
			if (mb_stripos(" $v", $filter)) { $ok = 1; break; }

		// COMMENT: анонимные объекты тоже сохраняем
		if (!$ok && !isset($a['name']) && !isset($a['operator'])) $ok = 1;

		if (!$ok) return;

		// определяем средние координаты для площадных объектов
		if ($type == 'w') $a += self::getObjectCenter('w'.$a['id']);
		if ($type == 'r') $a += self::getObjectCenter('r'.$a['id']);

		array_push($this->osm_objects, $a);
	}
	/** текстовые XML данные объекта */
	static function getOsmXML($id)
	{
		$object = 'node';
		if ($id[0] == 'w') $object = 'way';
		if ($id[0] == 'r') $object = 'relation';
		$type = $object[0];

		$id  = preg_replace('/\D/', '', $id);
		$h   = substr("$id", 0, 2);
		$dir = $_SERVER["DOCUMENT_ROOT"]."/_/_objects/$type/$h";
		@mkdir($dir, 0777, true);
		$fname = "$dir/$id";

		$page = '';
		if (file_exists($fname))
			$page = file_get_contents($fname);

		if (!strpos($page, '</osm>'))
		{
			echo "// Download $id\n";
//			$this->log("OSM API: $type$id");
			if ($object != 'node') $id .= '/full';
			$page = @file_get_contents("http://api.openstreetmap.org/api/0.6/$object/$id");
			if ($page)
			file_put_contents($fname, $page);
		}
		return $page;
	}
	/** все поля объекта в виде хеша */
	static function getObject($id)
	{
		$a = array();
		$st = self::getOsmXML($id);
		if (!$st) return $a;
		try {
		$osm = new SimpleXMLElement($st);
		} catch (Exception $e) { echo "// Error parse XML for $id\n"; return $a; }
		$item = ($id[0] == 'n') ? $osm->node : $osm->way;
		foreach ($item->attributes() as $k => $v) $a[$k] = (string)$v;
		foreach ($item->tag as $tag) $a[(string)$tag->attributes()['k']] = (string)$tag->attributes()['v'];
		ksort($a);
		$a['id'] = $id;
		return $a;
	}
	/** получение центра площадного объекта */
	static function getObjectCenter($id)
	{
		$st  = self::getOsmXML($id);
		if (!$st) return array();
		try {
		$osm = @new SimpleXMLElement($st);
		} catch (Exception $e) { echo "// Error parse XML for $id!\n"; return array(); }

		// рассчитываем средние координаты для веев
		$a = array('lat' => 0, 'lon' => 0); $n = 0;
		foreach ($osm->node as $nd)
		{
			$a['lat'] += (float)$nd->attributes()->lat;
			$a['lon'] += (float)$nd->attributes()->lon;
			$n++;
		}
		if ($n)
		{
			$a['lat'] /= $n;
			$a['lon'] /= $n;
		}
		return $a;
	}
}
