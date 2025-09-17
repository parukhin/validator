<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class tatneft extends Validator
{
	protected $domain = 'https://api.gs.tatneft.ru/api/v2/azs/';

	static $urls = [
		'RU-AL'  => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-BA'  => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-ME'  => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-MO'  => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-TA'  => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-UD'  => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-CU'  => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-KDA' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-STA' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-ARK' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-BEL' => ['operator' => 'ООО "Запад НП"'],
		'RU-VGG' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-VLA' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-VLG' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-VOR' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-KEM' => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-KGN' => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-LEN' => ['operator' => 'ООО "Татнефть-АЗС-Северо-Запад"'],
		'RU-LIP' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-MOS' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-NIZ' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-NGR' => '',
		'RU-OMS' => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-ORE' => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-PNZ' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-PSK' => ['operator' => 'ООО "Татнефть-АЗС-Северо-Запад"'],
		'RU-ROS' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-RYA' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-SAM' => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-SVE' => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-SMO' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-TVE' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-TOM' => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-TUL' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-ULY' => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-CHE' => ['operator' => 'ООО "Татнефть-АЗС Центр"'],
		'RU-YAR' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-MOW' => ['operator' => 'ООО "Татнефть-АЗС-Запад"'],
		'RU-SPE' => ['operator' => 'ООО "Татнефть-АЗС-Северо-Запад"']
		//'' => ['id' => ''],
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'fuel',
		'ref'             => '',
		'name'            => 'Татнефть',
		'name:ru'         => 'Татнефть',
		'name:en'         => 'Tatneft',
		'brand'           => 'Татнефть',
		'operator'        => '',
		'contact:website' => 'https://azs.tatneft.ru/',
		'contact:phone'   => '+7 800 5555911',
		'opening_hours'   => '24/7',
		'fuel:octane_98' => '',
		'fuel:octane_95'  => '',
		'fuel:octane_92'  => '',
		'fuel:octane_80'  => '',
		'fuel:diesel'     => '',
		'fuel:lpg'        => '',
		'fuel:cng'        => '',
		'shop'            => '', // отд. точка
		'car_wash'        => '', // отд. точка
		'cafe'            => '', // отд. точка
		'toilets'         => '', // отд. точка
		'compressed_air'  => '', // отд. точка
		'internet_access' => '',
		'full_service' 	  => '',
		'vacuum_cleaner'  => '', // отд. точка
		'atm'  			  => '', // отд. точка
		'lat'             => '',
		'lon'             => '',
		'_addr'           => ''
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=fuel][name~"Татнефть",i]'
	];

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
		$st = json_decode($st, true);
		if (is_null($st)) {
			return;
		}

		foreach ($st['data']  as $obj) {

            // Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			// $obj['ref'] = $obj['number'];
			$obj['_addr'] = $obj['address'];

			$obj['operator'] = static::$urls[$this->region]['operator'];

            // Виды топлива
				foreach ($obj['fuel'] as $fuel) {
					switch ($fuel['fuel_type_id']) {
						case 29: case 36:
							$obj['fuel:octane_92'] = 'yes';
							break;
						case 34: case 74:
							$obj['fuel:octane_95'] = 'yes';
							break;
						case 40: case 82:
							$obj['fuel:octane_98'] = 'yes';
							break;
						case 80:
							$obj['fuel:octane_100'] = 'yes';
							break;
						case 37:
							$obj['fuel:lpg'] = 'yes';
							break;
						case 30: case 46:
							$obj['fuel:diesel'] = 'yes';
							break;
						case 33:
							$obj['fuel:cng'] = 'yes';
							break;
						case 35:
							$obj['fuel:adblue'] = 'yes';
							break;
						default:
							$this->log("Parse error! (tatneft: Неизвестный вид топлива:" . print_r($fuel['fuel_type_id'], true));
							break;
					}
				}

				/* Услуги // работают, отключил, чтобы не дублировать существующие точки cafe, shop etc. 
				$services = [
					'Заправщик'           			=> 'full_service',    		// 1
					'Подкачка шин'         			=> 'compressed_air',  		// 2
					'Кафе'            				=> 'cafe',            		// 3
					'Автосервис'      				=> '',                		// 4
					'Парковка'  					=> '',                		// 5
					'Банкомат'  					=> 'atm',             		// 7
					'Долив омывающей жидкости' 		=> '',                		// 8
					'Wi-Fi'     					=> 'internet_access', 		// 9
					'Мойка'  						=> 'car_wash',        		// 10
					'Игровая комната'    			=> '',                		// 13
					'Магазин'          				=> 'shop',            		// 14
					'Туалет'    					=> 'toilets',         		// 15
					'Шиномонтаж'         			=> 'service:vehicle:tyres', // 16
					'Зарядка мобильных устройств' 	=> '',                		// 17
					'Пылесос'          				=> 'vacuum_cleaner',  		// 18
					'Парковка грузовиков' 			=> ''                 		// 19
				]; 

				foreach ($obj['features'] as $features) {
					switch ($features) {
						case 1:
							$obj['full_service'] = 'yes';
							break;
						case 2:
							$obj['compressed_air'] = 'yes';
							break;
						case 3:
							$obj['cafe'] = 'yes';
							break;
						case 7:
							$obj['atm'] = 'yes';
							break;
						case 9:
							$obj['internet_access'] = 'wlan';
							break;
						case 10:
							$obj['car_wash'] = 'yes';
							break;
						case 14:
							$obj['shop'] = 'yes';
							break;
						case 15:
							$obj['toilets'] = 'yes';
							break;
						case 18:
							$obj['vacuum_cleaner'] = 'yes';
							break;
						case 4: case 5: case 8: case 13: case 16: case 17: case 19:
							break;
						default:
							$this->log("Parse error! (tatneft: Неизвестный вид услуги: '$features').");
							break;
					}
				} */

			$this->addObject($this->makeObject($obj));
		}
	}
}
