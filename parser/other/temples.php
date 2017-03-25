<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class temples extends Validator
{
	protected $domain = 'http://www.temples.ru/export_osm.php?send=on&RegionID=';

	static $urls = [
		'RU-ALT' => '717',
		'RU-AMU' => '682',
		'RU-ARK' => '706',
		'RU-AST' => '740',
		'RU-BEL' => '32',
		'RU-VLA' => '34',
		'RU-VGG' => '741',
		'RU-VLG' => '707',
		'RU-VOR' => '35',
		'RU-ZAB' => '725',
		'RU-IVA' => '36',
		'RU-IRK' => '719',
		'RU-KGD' => '708',
		'RU-KLU' => '37',
		'RU-KAM' => '683',
		'RU-KC'  => '735',
		'RU-KEM' => '720',
		'RU-KIR' => '694',
		'RU-KOS' => '38',
		'RU-KDA' => '738',
		'RU-KYA' => '718',
		'RU-KGN' => '726',
		'RU-KRS' => '39',
		'RU-LEN' => '709',
		'RU-LIP' => '40',
		'RU-MAG' => '684',
		'RU-MOW' => '41',
		'RU-MOS' => '42',
		'RU-MUR' => '1785',
		'RU-NIZ' => '695',
		'RU-NGR' => '711',
		'RU-NVS' => '721',
		'RU-OMS' => '722',
		'RU-ORE' => '696',
		'RU-ORL' => '43',
		'RU-PNZ' => '697',
		'RU-PER' => '702',
		'RU-PRI' => '680',
		'RU-PSK' => '712',
		'RU-AD'  => '730',
		'RU-AL'  => '713',
		'RU-BA'  => '688',
		'RU-BU'  => '714',
		'RU-DA'  => '731',
		'RU-IN'  => '732',
		'RU-KL'  => '734',
		'RU-KR'  => '704',
		'RU-KO'  => '705',
		'RU-CR'  => '11015',
		'RU-ME'  => '689',
		'RU-MO'  => '690',
		'RU-SA'  => '679',
		'RU-SE'  => '736',
		'RU-TA'  => '691',
		'RU-TY'  => '715',
		'RU-KK'  => '716',
		'RU-ROS' => '742',
		'RU-RYA' => '44',
		'RU-SAM' => '699',
		'RU-SPE' => '703',
		'RU-SAR' => '700',
		'RU-SAK' => '685',
		'RU-SVE' => '727',
		'RU-SEV' => '11052',
		'RU-SMO' => '45',
		'RU-STA' => '739',
		'RU-TAM' => '46',
		'RU-TVE' => '47',
		'RU-TOM' => '723',
		'RU-TUL' => '48',
		'RU-TYU' => '728',
		'RU-UD'  => '692',
		'RU-ULY' => '701',
		'RU-KHA' => '681',
		'RU-CHE' => '729',
		'RU-CE'  => '737',
		'RU-CU'  => '693',
		'RU-CHU' => '687',
		'RU-YAR' => '49'
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'          => 'place_of_worship',
		'building'         => '',
		'name'             => '',
		'religion'         => 'christian',
		'denomination'     => 'russian_orthodox',
		'denomination:ru'  => '',
		'russian_orthodox' => '',
		'disused'          => '',
		'alt_name'         => '',
		'ref:temples.ru'   => '',
		'community:gender' => '',
		'start_date'       => '',
		'contact:website'  => '',
		'lat'              => '',
		'lon'              => '',
		'_id'              => '',
		'_addr'            => '',
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=place_of_worship]'
	];

	/* Парсер страницы */
	protected function parse($st)
	{
		$st = str_replace(' />', '></end>', $st);
		if (preg_match_all('#'
		.'ID="(?<id>\d+)'
		.'.+?Name>(?<name>[^<]+)'
		.'.+?Status>(?<state>[^<]+)'
		.'.+?TypeObject>(?<type>[^<]+)'
		.'.+?Address>(?<_addr>[^<]+)'
		.'.+?WebSite>(?<website>[^<]*)'
		.'.+?Date>(?<start_date>[^<]+)'
		.'.+?Confession>(?<confession>[^<]+)'
		.'.+?Coordinates>(?<lon>[\d.]+),(?<lat>[\d.]+)'
		."#su", $st, $list, PREG_SET_ORDER))
		foreach ($list as $obj)
		{
			if ($obj['state'] == 'не сохр.') continue;
			if ($obj['state'] == 'сохр.') $obj['disused']  = 'yes';

			$obj['ref:temples.ru'] = $obj['id'];
			$obj['name']  = preg_replace('/,? (что|во|в|на|при|у) .+/', '', $obj['name']); // сокращаем название
			$obj['name']  = preg_replace('/\(.+?\)/', '', $obj['name']); // убираем название в скобках

			// старообрядчество
			$c = $obj['confession'];
			if (strpos($c, 'белокриничники') || strpos($c, 'федосеевцы')) { $c = 'РПСЦ'; $obj['disused'] = 'yes'; }
			if (strpos($c, 'диноверческая'))
			{
				if (strpos(" $c", 'МП')) $obj['russian_orthodox'] = 'yes'; // признают патриарха
				$c = 'edin';
			}
			if ($c == 'ДПЦ' || $c == 'РПСЦ' || $c == 'РДЦ' || $c == 'ДКЦ' || $c == 'edin')
			{
				$obj['denomination'] = 'old_believers';
				if ($c != 'edin')
				$obj['denomination:ru'] = $c;
			}

			// инакомыслящие
			if ($c == 'ПЦР (ИПЦ)') $c = 'ИПЦ (ПЦР)';
			if ($c == 'РосПЦ' || $c == 'РПАЦ' || strpos(" $c", 'ИПЦ'))
			{
				$obj['denomination'] = 'dissenters';
				$obj['denomination:ru'] = $c;
			}

			// зарубежная
			if (strpos(" $c", 'РПЦЗ'))
			{
				$obj['denomination:ru'] = 'РПЦЗ';
				if (strpos(" $c", 'МП')) $obj['russian_orthodox'] = 'yes'; // признают патриарха
			}

			// храм не действует
			if (strpos(" $c", 'равославн')) $obj['disused'] = 'yes';

			// COMMENT: церкви с неопределенной конфессией
			if ($c != 'РПЦ МП' && empty($obj['denomination:ru'])
				&& empty($obj['russian_orthodox']) && empty($obj['disused']))
			{
				//print_r($obj);
			}

			// FIXME: обрабатывать в датах фразы типа "2-я треть", "1-я пол."
			$date = $obj['start_date'];
			$date = str_replace(
				array('ок. ', 'нач.', 'сер.', 'кон.', 'не позже', '-е', '-х',
					'строится', ' в.', ' вв.', 'рубеж', 'вв',
					'XXI', 'XX', 'ХХ', 'XIX', 'XVIII', 'XVII', 'XVI', 'XV', 'XIV',
				),
				array('~', 'early', 'mid', 'late', 'before', 's', 's',
					'','','','', '',
					'C21', 'C20', 'C20', 'C19', 'C18', 'C17', 'C16', 'C15', 'C14',
				),
				$date);
			$date = preg_replace('/\s*-\s*/',        '-', $date);
			$date = preg_replace('/(\d)-(\d|C)/', '$1..$2', $date);
			$obj['start_date'] = trim($date);

			$obj['contact:website'] = preg_replace('#/$#', '', $obj['website']);

			if (mb_stripos(' '.$obj['name'],  'собор'))     $obj['building'] = 'cathedral';
			if (mb_stripos(' '.$obj['name'],  'часовня'))   $obj['building'] = 'chapel';
			if (mb_stripos(' '.$obj['name'],  'монастырь')){$obj['amenity'] = 'monastery';
				if (mb_stripos(' '.$obj['name'], 'мужск')) $obj['community:gender'] = 'male';
				if (mb_stripos(' '.$obj['name'], 'женск')) $obj['community:gender'] = 'female';
			}
			if (0
				|| mb_stripos(' '.$obj['name'],  'церковь')
				|| mb_stripos(' '.$obj['name'],  'храм')
				) $obj['building'] = 'church';

			$this->addObject($this->makeObject($obj));
		}
	}
}
