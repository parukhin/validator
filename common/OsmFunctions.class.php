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

		$this->log("filter data ".$this->region." / ".implode(" ", $this->filter));

        if ($page != '')    //$this->log("failed request");
		    $this->filterOsm($page); 
	}
    private function updateOverPass($region, $filter)
    {
        $queryUrl = "http://overpass.osm.rambler.ru/cgi/interpreter";
        $queryParam = "data=[out:xml] [timeout:60];";

		$queryParam = $queryParam."area[ref=\"".$region."\"][admin_level=4][boundary=administrative]->.a; ";
		//old syntax
        //$queryParam = $queryParam."area [\"addr:country\"=\"RU\"] [\"admin_level\"=\"4\"] [\"iso3166-2\"=\"".$region."\"]->.a; ";
		//$queryParam = $queryParam."{{geocodeArea:".$region."}}->.a; ";

        $queryParam = $queryParam."( ";

        foreach ($filter as $value)
        {
            $queryParam = $queryParam."relation (area.a) ";
            $queryParam = $queryParam.$value;
            $queryParam = $queryParam."; >; ";
            //$queryParam = $queryParam."; ";
        }

        foreach ($filter as $value)
        {
            $queryParam = $queryParam."way (area.a) ";
            $queryParam = $queryParam.$value;
            $queryParam = $queryParam.";>";
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
    private function filterOsm($src)
    {
        //echo $src;
		$xml = new SimpleXMLElement($src);
		$this->osm_objects = array();
		mb_internal_encoding('utf-8');
		$this->timestamp = '';

        //Подготовим фильтр
		$filter = array();
        foreach ($this->filter as $value) //  '[amenity=bank][name~"[Аа]льфа"]'
            //  пережовываем на ключ/значение 
		    if (preg_match_all('/\[(?<key>\w+)(?:(?<op>[=~])(?<val>(?:\w|"[^"]+")+))?\]/', $value, $m, PREG_SET_ORDER))
            {
        		$f = array();
		        foreach ($m as $obj)
		        {
                    $fitem = array(
                            "k" => $obj['key'],
                            "o" => $obj['op'],
                            "v" => trim($obj['val'],'"')
                    );
                    array_push($f, $fitem);

                }
	        	array_push($filter, $f);
            }

        //print_r($filter);
        //return;
        //массив с координатами точек...
        $nodesCoord = array();

		foreach ($xml->node as $v) 
            $this->testObject($v, 'n', $nodesCoord, $filter);
        foreach ($xml->way  as $v) 
            $this->testObject($v, 'w', $nodesCoord, $filter);
		foreach ($xml->relation as $v) 
            $this->testObject($v, 'r', $nodesCoord, $filter);
	}
	/** попадает ли объект в фильтр? */
	private function testObject($item, $type, &$coord, $filter)
	{
		$a = array();
		foreach ($item->attributes() as $k => $v) 
            $a[$k] = (string)$v;
		foreach ($item->tag as $tag) 
            $a[(string)$tag->attributes()['k']] = (string)$tag->attributes()['v'];
		$a['id'] = $type.$a['id'];

        // определяем средние координаты для площадных объектов
        if (!isset($a['lat']) || !isset($a['lon']) )    //if (($type == 'w') || ($type == 'r'))
            $a += self::getObjectCenter($item, $coord);

        //Запоминам координаты точек, пригодится, когда будем считать центры ...
        $coord[$a["id"]] = array(
                "lat" => (float)$a["lat"],
                "lon" => (float)$a["lon"]);

    	// фильтруем
        $found = 1;
        foreach ($filter as $item) //  фильтров можетбыть несколько, срабатывает какой-то один
        {
            $found = 1;
            foreach ($item as $f) //  '[amenity=bank][name~"[Аа]льфа"]'
            {
                if (!isset($a[$f['k']]))    //Нет нужного ключа
                {   
                    $found = 0;
                    break;
                }
                if (isset($f['v']))         //Если надо фильтровать по значению...
                {
                    if (($f['o'] == '=') &&
                        ($f['v'] != $a[$f['k']]))
                    {
                        echo 'val '.$f['v'].' != '.$a[$f['k']].'\n';
                        $found = 0;
                        break;
                    }
                    else if (($f['o'] == '~') && 
                        !preg_match('/'.$f['v'].'/', $a[$f['k']]))
                    {
                        $found = 0;
                        break;
                    }
                }
                
            }
            if ($found)
                break;
        }
        if (!$found)
            return;
    	// COMMENT: анонимные объекты тоже сохраняем
		//if (!$ok && !isset($a['name']) && !isset($a['operator'])) $ok = 1;


        // опеделяем самую свежую правку
		if ($this->timestamp < $a['timestamp']) 
            $this->timestamp = $a['timestamp'];

		// убираем ненужные теги
		unset($a['version']);
		unset($a['timestamp']);
		unset($a['uid']);
		unset($a['user']);


		array_push($this->osm_objects, $a);
	}

    static function file_get_content_timeout ($URL, $timeout = 60)
    { 
        $timeout = (int) $timeout; 
        if ($timeout < 1) 
            $timeout = 1; 
        $Error = "Can't connect to remote URL"; 
        $content = ''; 

        if ($handler = fsockopen ($URL, 80, $Error, $Error, $timeout)){ 
            $H = "GET / HTTP/1.1\r\n"; 
            $H.= "Host: $URL\r\n"; 
            $H.= "Connection: Close\r\n\r\n"; 

            fwrite($handler, $H); 

            while (!feof ($handler)){ 
                $content.= fread ($handler, 4096); 
            } 

            fclose ($handler); 
            echo $content; 
        } 
    }

	/** получение центра площадного объекта */
	static function getObjectCenter($item, $coord)
	{
        //echo $item->attributes()->id;
        $time_start = microtime(true);

		$a = array('lat' => 0, 'lon' => 0); $n = 0;
        // рассчитываем средние координаты для веев
		foreach ($item->nd as $nd)
		{
			$a['lat'] += $coord['n'.$nd->attributes()->ref]['lat'];
			$a['lon'] += $coord['n'.$nd->attributes()->ref]['lon'];
			$n++;
		}
        //Реляции... находим вей ... и считаем центр...
        foreach ($item->member as $m)
        {
            //print_r($m);
            //echo "//way[@id=".$m->attributes()->ref."]\r\n";
            if ($m->attributes()->type=="way")
            {
                $a['lat'] += $coord['w'.$m->attributes()->ref]['lat'];
			    $a['lon'] += $coord['w'.$m->attributes()->ref]['lon'];
			    $n++;
            }
        }

		if ($n)
		{
			$a['lat'] /= $n;
			$a['lon'] /= $n;
		}
        //print_r($item);
        //$time_end = microtime(true);
        //$time = $time_end - $time_start;

        //echo $item->attributes()->id.': time '.$time.' n '.$n.' lat '.$a['lat'].' lon '.$a['lon'].";\r\n";
        //echo $item->attributes()->id.':  n '.$n.' lat '.$a['lat'].' lon '.$a['lon'].";\r\n";
		return $a;
	}




}
