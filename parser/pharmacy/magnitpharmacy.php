<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/common/lib/phpquery/phpQuery-onefile.php';

class magnitpharmacy extends Validator
{
	protected $domain = 'https://magnit-info.ru';

	static $urls = [
		'RU-ALT' => ['rid' => '1389'],
		'RU-ARK' => ['rid' => '829'],
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
		'RU-KB'  => ['rid' => '67079'],
		'RU-KL'  => ['rid' => '23'],
		'RU-KC'  => ['rid' => '21'],
		'RU-KR'  => ['rid' => '5'],
		'RU-KO'  => ['rid' => '834'],
		'RU-ME'  => ['rid' => '36'],
		'RU-MO'  => ['rid' => '379'],
		'RU-SE'  => ['rid' => '19'],
		'RU-TA'  => ['rid' => '35'],
		'RU-UD'  => ['rid' => '67071'],
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
		'RU-ULY' => ['rid' => '30'],
		'RU-KHM' => ['rid' => '831'],
		'RU-CHE' => ['rid' => '33'],
		'RU-CU'  => ['rid' => '38'],
		'RU-YAN' => ['rid' => '67075'],
		'RU-YAR' => ['rid' => '11']
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'pharmacy',
		'ref'             => '',
		'name'            => 'Магнит',
		'name:ru'         => 'Магнит',
		'name:en'         => 'Magnit',
		'operator'        => 'АО Тандер',
		'contact:website' => 'https://magnit-info.ru',
		'contact:phone'   => '+7 800 2009002',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand:wikidata'  => 'Q940518',
		'brand:wikipedia' => 'ru:Магнит (сеть магазинов)'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=pharmacy][name~"Магнит",i]'
	];

	//protected $type_id = '1258'; // Магнит
	//protected $type_id = '1257'; // Семейный Магнит
	//protected $type_id = '1259'; // Магнит Косметик
	protected $type_id = '67420'; // Магнит Аптека
	//protected $type_id = '67424'; // Магнит Опт

	/* Обновление данных по региону */
	public function update()
	{
		$this->log('Обновление данных по региону '.$this->region.'.');

		$rid = static::$urls[$this->region]['rid'];
		$url = $this->domain.'/buyers/adds/?ajax=changeRegion&type='.$this->type_id.'&region='.$rid;

		$page = $this->get_web_page($url);
		if (is_null($page)) {
			return;
		}

		$a = json_decode($page, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a['settlement'] as $city) {
			if ($city['id'] == 0) {
				continue;
			}

			$url = $this->domain.'/buyers/adds/?ajax=changeCity&type='.$this->type_id.'&region='.$rid.'&settlement='.$city['id'];

			$page = $this->get_web_page($url);
			if (is_null($page)) {
				return;
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

		foreach ($a['points'] as $obj) {
			$obj['ref'] = $obj['id'];
			$obj['_addr'] = $obj['address'];
			$obj['lat'] = $obj['lat'];
			$obj['lon'] = $obj['lng'];
			$obj['opening_hours'] = $this->time($obj['time']);

			$this->addObject($this->makeObject($obj));
		}
	}
}