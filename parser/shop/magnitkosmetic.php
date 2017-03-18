<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/common/lib/phpquery/phpQuery-onefile.php';

class magnitkosmetic extends Validator
{
	protected $domain = 'http://www.magnit-info.ru';

	static $urls = [
		'RU-ARK' => ['rid' => '829'],
		'RU-ALT' => ['rid' => '1389'],
		'RU-AST' => ['rid' => '22'],
		'RU-BEL' => ['rid' => '37'],
		'RU-BRY' => ['rid' => '17'],
		'RU-VLA' => ['rid' => '14'],
		'RU-VGG' => ['rid' => '27'],
		'RU-VLG' => ['rid' => '9'],
		'RU-VOR' => ['rid' => '39'],
		'RU-IVA' => ['rid' => '13'],
		'RU-KLU' => ['rid' => '16'],
		'RU-KEM' => ['rid' => '1390'],
		'RU-KIR' => ['rid' => '832'],
		'RU-KOS' => ['rid' => '12'],
		'RU-KDA' => ['rid' => '25'],
		'RU-KYA' => ['rid' => '1076'],
		'RU-KGN' => ['rid' => '827'],
		'RU-KRS' => ['rid' => '43'],
		'RU-LEN' => ['rid' => '6'],
		'RU-LIP' => ['rid' => '41'],
		'RU-MOW' => ['rid' => '1305'],
		'RU-MOS' => ['rid' => '15'],
		'RU-MUR' => ['rid' => '1335'],
		'RU-NIZ' => ['rid' => '823'],
		'RU-NGR' => ['rid' => '824'],
		'RU-NVS' => ['rid' => '1075'],
		'RU-OMS' => ['rid' => '1030'],
		'RU-ORE' => ['rid' => '32'],
		'RU-ORL' => ['rid' => '44'],
		'RU-PNZ' => ['rid' => '29'],
		'RU-PER' => ['rid' => '830'],
		'RU-PSK' => ['rid' => '10'],
		'RU-AD'  => ['rid' => '380'],
		'RU-BA'  => ['rid' => '34'],
		'RU-KB'  => ['rid' => '20'],
		'RU-KL'  => ['rid' => '23'],
		'RU-KC'  => ['rid' => '21'],
		'RU-KR'  => ['rid' => '5'],
		'RU-KO'  => ['rid' => '834'],
		'RU-ME'  => ['rid' => '36'],
		'RU-MO'  => ['rid' => '379'],
		'RU-SE'  => ['rid' => '19'],
		'RU-TA'  => ['rid' => '35'],
		'RU-UD'  => ['rid' => '2817'],
		'RU-KK'  => ['rid' => '1725'],
		'RU-ROS' => ['rid' => '26'],
		'RU-RYA' => ['rid' => '42'],
		'RU-SAM' => ['rid' => '31'],
		'RU-SPE' => ['rid' => '1334'],
		'RU-SAR' => ['rid' => '28'],
		'RU-SVE' => ['rid' => '820'],
		'RU-SMO' => ['rid' => '7'],
		'RU-STA' => ['rid' => '24'],
		'RU-TAM' => ['rid' => '40'],
		'RU-TVE' => ['rid' => '8'],
		'RU-TOM' => ['rid' => '1391'],
		'RU-TUL' => ['rid' => '18'],
		'RU-TYU' => ['rid' => '1035'],
		'RU-UD'  => ['rid' => '822'],
		'RU-ULY' => ['rid' => '30'],
		'RU-KHM' => ['rid' => '831'],
		'RU-CHE' => ['rid' => '33'],
		'RU-CU'  => ['rid' => '38'],
		'RU-YAN' => ['rid' => '63627'],
		'RU-YAR' => ['rid' => '11']
	];

	/* Поля объекта */
	protected $fields = [
		'shop'            => 'chemist',
		'ref'             => '',
		'name'            => 'Магнит Косметик',
		'name:ru'         => 'Магнит Косметик',
		'name:en'         => '',
		'operator'        => 'АО Тандер',
		'contact:website' => 'https://magnitcosmetic.ru',
		'contact:phone'   => '+7 800 2009002',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'wikidata'        => 'Q940518',
		'wikipedia'       => 'ru:Магнит_(сеть_магазинов)'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[shop=chemist][name~"Магнит Косметик",i]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		$this->log('Обновление данных по региону '.$this->region.'.');

		$rid = static::$urls[$this->region]['rid'];

		//$id = '1257'; // гипермаркеты
		//$id = '1258'; // универсамы
		$id = '1259'; // косметик

		$url = $this->domain.'/buyers/adds/1258/'.$rid.'/1';

		// Загружаем страницу со списком cid
		$page = $this->get_web_page($url);
		if (is_null($page)) {
			return;
		}

		$url = 'http://magnit-info.ru/functions/bmap/func.php';

		phpQuery::newDocument($page);

		$options = pq('#city_select')->children('option');
		foreach ($options as $option) {
			$cid = pq($option)->attr('value');
			if ($cid == 0) {
				continue; // пропускаем 1 строку
			}

			$query = "op=get_shops&SECTION_ID=$id&RID=$rid&CID=$cid";

			$page = $this->get_web_page($url, $query);
			if (is_null($page)) { // если страница не загружена
				return;
			}
			if (empty($page)) { // если страница пустая
				continue;
			}
			$this->parse($page);
		}
	}

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a['list'] as $obj) {
			$obj['ref'] = $obj['id'];
			$obj['_addr'] = $obj['addr'];
			$obj['lat'] = $obj['cx'];
			$obj['lon'] = $obj['cy'];
			$obj['opening_hours'] = $this->time($obj['time']);

			$this->addObject($this->makeObject($obj));
		}
	}
}