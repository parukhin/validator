<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class taifnk extends Validator
{
	protected $domain = 'https://taifazs.ru/tools/get-fuels.php';

	static $urls = [
		'RU-TA'  => '',
		'RU-SAM' => '',
		'RU-UD'  => '',
		'RU-ULY' => '',
		'RU-CU'  => '',
		'RU-KIR' => ''
		//'' => ['id' => ''],
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'fuel',
		'ref'             => '',
		'name'            => 'Таиф-НК',
		'name:ru'         => '',
		'brand'           => 'ТАИФ-НК',
		'operator'        => 'ООО "ТАИФ-НК АЗС"',
		'contact:website' => 'https://taifazs.ru/',
		'contact:phone'   => '', // +7 800 3330810
		'opening_hours'   => '24/7',
		'fuel:octane_98'  => '',
		'fuel:octane_95'  => '',
		'fuel:octane_92'  => '',
		'fuel:diesel'     => '',
		'fuel:lpg'        => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => ''
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=fuel][name~"Таиф",i]'
	];

	/* Парсер страницы */
	protected function parse($st)
	{
		$st = json_decode($st, true);
		if (is_null($st)) {
			return;
		}

		foreach ($st as $obj) {
			$obj['lat'] = $obj['fuelCoords'][0];
			$obj['lon'] = $obj['fuelCoords'][1];

            // Отсеиваем по региону
			if (($this->region != 'RU') && !$this->isInRegionByCoords($obj['lat'], $obj['lon'])) {
				continue;
			}

			// ref АЗС из fuelShortcode
			$obj['ref'] = $obj['fuelShortcode'];
            $obj['ref'] = preg_replace("/[^0-9\/]/", '', $obj['fuelShortcode']);
			$obj['_addr'] = $obj['fuelAdress'];

			// приведение номеров телефонов к формату E.123
			if (strlen($obj['fuelPhone']) == 0)
			{
				$obj['contact:phone'] = '+7 800 3330810';
			}
			else
			{
				if ((strlen(trim($obj['fuelPhone'])) == 15) && (strpos(trim($obj['fuelPhone']), '8-' ) === 0))
				{
					$phone = trim($obj['fuelPhone']);
					$phone = substr_replace($phone, '+7 ', 0, 2);
					$phone = substr_replace($phone, ' ', 6, 1);
					$phone = str_replace('-','',$phone);
					if ($phone == '+7 800 3330810')
					{
						$obj['contact:phone'] = $phone;
					}
					else
					{
						$obj['contact:phone'] = $phone.';+7 800 3330810';
					}
				}
			}


            /* Виды топлива
			$fuels = [
				'АИ-92-К5'     => 'fuel:octane_92',
				'АИ-92-К5 ЭКО' => 'fuel:octane_92',
				'АИ-95-К5'     => 'fuel:octane_95',
				'АИ-98-К5'     => 'fuel:octane_98',
				'газ'          => 'fuel:lpg',
				'дизель'       => 'fuel:diesel'
			]; */
				foreach ($obj['fuelType'] as $fuel) {
					switch ($fuel) {
						case 'АИ-92-К5':
							$obj['fuel:octane_92'] = 'yes';
							break;
						case 'АИ-92-К5 ЭКО':
							$obj['fuel:octane_92'] = 'yes';
							break;
						case 'АИ-95-К5':
							$obj['fuel:octane_95'] = 'yes';
							break;
						case 'АИ-98-К5':
							$obj['fuel:octane_98'] = 'yes';
							break;
						case 'газ':
							$obj['fuel:lpg'] = 'yes';
							break;
						case 'дизель':
							$obj['fuel:diesel'] = 'yes';
							break;
						default:
							$this->log("Parse error! (taifnk: Неизвестный вид топлива: '$fuel').");
							break;
					}
				}

			$this->addObject($this->makeObject($obj));
		}
	}
}
