<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class rigla extends Validator
{
	// откуда скачиваем данные
	protected $domain = 'https://www.rigla.ru/graphql';

	static $urls = [
		'RU-ALT' => ['22'], // Алтайский край
		'RU-AMU' => ['28'], // Амурская область
		'RU-ARK' => ['29'], // Архангельская область
		'RU-AST' => ['30'], // Астраханская область
		'RU-BEL' => ['31'], // Белгородская область
		'RU-BRY' => ['32'], // Брянская область
		'RU-VLA' => ['33'], // Владимирская область
		'RU-VGG' => ['34'], // Волгоградская область
		'RU-VLG' => ['35'], // Вологодская область
		'RU-VOR' => ['36'], // Воронежская область
		'RU-YEV' => ['79'], // Еврейская автономная область
		'RU-ZAB' => ['75', '1075'], // Забайкальский край
		'RU-IVA' => ['37'], // Ивановская область
		'RU-IRK' => ['38'], // Иркутская область
		'RU-KGD' => ['39'], // Калининградская область
		'RU-KAL' => ['40'], // Калужская область
		'RU-KAM' => ['41'], // Камчатский край
		'RU-KIR' => ['43'], // Кировская область
		'RU-KOS' => ['44'], // Костромская область
		'RU-KDA' => ['23'], // Краснодарский край
		'RU-KYA' => ['24'], // Красноярский край
		'RU-KRS' => ['46'], // Курская область
		'RU-LIP' => ['48'], // Липецкая область
		'RU-MOS' => ['77'], // Московская область
		'RU-MOW' => ['77'], // Москва
		'RU-MUR' => ['51'], // Мурманская область
		'RU-NIZ' => ['52'], // Нижегородская область
		'RU-NGR' => ['53'], // Новгородская область
		'RU-ORE' => ['56'], // Оренбургская область
		'RU-ORL' => ['57'], // Орловская область
		'RU-PNZ' => ['58'], // Пензенская область
		'RU-PRI' => ['25', '1025'], // Приморский край
		'RU-PSK' => ['60'], // Псковская область
		'RU-AD'  => ['1'], // Республика Адыгея
		'RU-BA'  => ['2'], // Республика Башкортостан
		'RU-BU'  => ['3'], // Республика Бурятия
		'RU-DA'  => ['5'], // Республика Дагестан
		'RU-KC'  => ['9'], // Республика Карачаево-Черкесия
		'RU-KR'  => ['10'], // Республика Карелия
		'RU-KO'  => ['11', '1011'], // Республика Коми
		'RU-ME'  => ['12'], // Республика Марий Эл
		'RU-TA'  => ['16'], // Республика Татарстан
		'RU-ROS' => ['61'], // Ростовская область
		'RU-RYA' => ['62'], // Рязанская область
		'RU-SAM' => ['63'], // Самарская область
		'RU-SAR' => ['64'], // Саратовская область
		'RU-SMO' => ['67'], // Смоленская область
		'RU-TAM' => ['68'], // Тамбовская область
		'RU-TVE' => ['69'], // Тверская область
		'RU-TOM' => ['70'], // Томская область
		'RU-TUL' => ['71'], // Тульская область
		'RU-TYU' => ['72'], // Тюменская область
		'RU-KHM' => ['86', '1086', '2086'], // Ханты-Мансийский автономный округ - Югра
		'RU-CHE' => ['74'], // Челябинская область
		'RU-CU'  => ['21'], // Чувашская Республика
		'RU-YAN' => ['89', '1089'], // Ямало-Ненецкий автономный округ
		'RU-YAR' => ['76'], // Ярославская область
		'RU-SPE' => ['78'], // Санкт-Петербург
		'RU-LEN' => ['78'], // Ленинградская область
		'RU-CR'  => ['82'], // Республика Крым
		'RU-SEV' => ['92'] // Севастополь
	];

	// поля объекта
	protected $fields = [
		'amenity'    		=> 'pharmacy',
		'name'    			=> 'Ригла',
		'brand'    			=> 'Ригла',
		'operator' 			=> '',
		'contact:website'  	=> 'https://www.rigla.ru/',
		'contact:phone'   	=> '',
		'opening_hours'   	=> '',
		'ref'   			=> '',
		'lat'   			=> '',
		'lon'   			=> '',
		'_addr' 			=> '',
		'brand:wikidata'    => 'Q4394431',
		'brand:wikipedia'   => 'ru:Ригла'

	];

	// фильтр для поиска объектов в OSM
    protected $filter = array(
        '[amenity=pharmacy][name~"Ригла",i]'
    );

	public function update()
	{
		$ids = static::$urls[$this->region];
		$url = $this->domain;

		foreach ($ids as $id) {
			$query = '{"query":"query pvzList($regionId:String, $sales:FilterTypeInput, $services:FilterTypeInput,'
				.'!$groupId: String) {\n pvzList: pvzList(\n pageSize: 10000\n filter: {\n is_active: { eq: \"1\" }'
				.'\n region_id: { eq: $regionId }\n sales: $sales\n services: $services,\n group_id: { eq: $groupId }'
				.'\n }\n ) {\n sales{\n label\n option_id\n }\n services{\n label\n option_id\n }\n items {\n entity_id'
				.'\n name\n region_id\n group_name\n group_id\n schedule\n latitude\n longitude\n address\n phone\n }\n }'
				.'\n}\n","variables":{"regionId":"'.$id.'","sales":{},"services":{},"groupId":1}}';
			$page = $this->get_web_page($url, $query);
			if (is_null($page)) {
				return;
			}
			$this->parse($page);
		}
	}

	/* Парсер страницы */
	protected function parse($st)
	{
		$st = json_decode($st, true);
		if (is_null($st)) {
			return;
		}

		foreach ($st['data']['pvzList']['items']  as $obj) {
			$obj['lat'] = $obj['latitude'];
			$obj['lon'] = $obj['longitude'];

            // Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			$obj['ref'] = $obj['entity_id'];
			$obj['_addr'] = $obj['address'];
			$obj['name'] = '';

			// Время работы
			$days = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];
			$schedule = array_combine(
				$days,
				array_map('trim', explode(';', $obj['schedule']))
			);
			$obj['opening_hours'] = $this->time($schedule);

			// Телефоны
			$phone = str_replace([' доб.',"\n"], ['-', ';'], $obj['phone']);
			// TODO добавить в функции phone() поддержку добавочных телефонов формата +74951234567-1234/5687
			// $obj['contact:phone'] = $this->phones($phone);
			$obj['contact:phone'] = $phone;

			$this->addObject($this->makeObject($obj));
		}
	}
}
