<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/common/Validator.class.php';

class akbarsbank_atm extends Validator
{
	protected $domain = 'https://www.akbars.ru';

	static $urls = [
		'RU-BU' => ['6cec4f44-c9a5-4df0-a8a8-491900e794a3'],
		'RU-ALT' => ['d13945a8-7017-46ab-b1e6-ede1e89317ad'],
		'RU-BA'  => ['7339e834-2cb4-4734-a4c7-1fca2c66e562', 'abd1bc35-ec51-437a-abee-76a4f620f662', 
                     '66eaa35f-28c3-437a-be40-9dac0c7ab820', '511a0136-f60c-451b-a2eb-3402103f1223', 
                     '2e5f4374-69eb-47c4-8067-933f61330aec', '3094563a-390d-433f-9e28-8fd42ed9152c', 
                     '84e0b23d-82fe-40a8-8739-55e679780dc3', '1850f37b-fa2e-49ae-aa93-df3715241f02'
                    ],
		'RU-KIR' => ['7ad714c1-1136-4c39-84c1-17e15dbc5aab'],
		'RU-KDA' => ['7dfa745e-aa19-4688-b121-b655c11e482f'],
		'RU-KYA' => ['9b968c73-f4d4-4012-8da8-3dacd4d4c1bd'],
		'RU-ME'  => ['f183b079-b65f-4781-9b79-310ba29b724d', '0648e41c-a09b-4eac-91cd-8cf61b9ccb7b', 
                     'cc0c0617-2712-4c27-8252-3b20527d981e', 'fbb7431a-17cf-481d-8806-ec6ee116fcfa'
                    ],
		'RU-MO'  => ['a8bff875-54ec-4dc3-8dc4-392dac15e5f9'],
		'RU-MOS' => ['derevnyaJukova'],
		'RU-MOW' => ['0c5b2444-70a0-4932-980c-b4dc0d3f02b5'],
        'RU-NGR' => ['8d0a05bf-3b8a-43e9-ac26-7ce61d7c4560'],
		'RU-NIZ' => ['e736e903-6bc3-450b-b8af-7909213dc9ef', '1d5a97d5-9bdf-44c9-ac42-e201833e7f28', '555e7d61-d9a7-4ba6-9770-6caa8198c483'],
		'RU-NVS' => ['8dea00e3-9aab-4d8e-887c-ef2aaa546456'],
		'RU-OMS' => ['140e31da-27bf-4519-9ea0-6185d681d44e'],
		'RU-ORE' => ['dce97bff-deb2-4fd9-9aec-4f4327bbf89b', '86204c33-b552-4ebd-a93a-9dc8b274ee9c'],
		'RU-PER' => ['a309e4ce-2f36-4106-b1ca-53e0f48a6d95'],
		'RU-PSK' => ['2858811e-448a-482e-9863-e03bf06bb5d4'],
		'RU-SAM' => ['242e87c1-584d-4360-8c4c-aae2fe90048e', 'bb035cc3-1dc2-4627-9d25-a1bf2d4b936b'],
		'RU-SPE' => ['c2deb16a-0330-4f05-821f-1d09c93331e6'],
		'RU-LEN' => ['c70a5280-c482-4f6e-801a-cdd6851eab50', 'f4a4b31f-9f0a-4fdb-804c-d67661085eb4', '1eb5260c-d69a-414b-9c84-01b987f9f209'],
		'RU-SAR' => ['c58d0505-54eb-4c34-8216-b14f7cdb0ecb', 'bf465fda-7834-47d5-986b-ccdb584a85a6', 
                     'c1d4d969-0083-4b04-9f4b-e9eaeaefbd6f', '2d06120f-ba70-4866-b46e-ec2bad9c4f42', 
                     '83f29047-8dd9-411d-ac4b-c5811ea815f1', '9c7bd9ab-610c-4606-a78e-a20f37cb43ea'
                    ],
		'RU-SVE' => ['2763c110-cb8b-416a-9dac-ad28a55b4402'],
		'RU-STA' => ['2a1c7bdb-05ea-492f-9e1c-b3999f79dcbc'],
		'RU-TA'  => ['82df31a7-f31d-4c1f-a22d-ce2a5269d0e7', 'd98e1898-1135-405c-89f3-fd38ca361c1d', 
                     'ad713bc9-76e3-46ae-a7ff-dbed9d2b6045', '748d7afa-7407-4876-9f40-764ecdd09bbd', 
                     '7d4fa85e-2ab6-4617-a0c5-4ecc1f2294aa', '3b69c322-9250-4e2a-a4e8-937c61f86356', 
                     '60365c49-05c2-45cc-bc66-c31dd7090009', 'df38e91c-2198-4dae-ac1b-52774fab2834', 
                     '88518af8-7780-4f6e-b0de-767a9c1fe82d', '05608021-d91c-4b36-bcaf-2df985f5a658', 
                     'c3c7b150-1b5b-49a6-ace2-a24b403b3b94', '50122d70-df5f-4618-af0a-e70a661f0668', 
                     '1ba8dcb1-bf5b-4f66-86de-daf707a655e7', '4c27b4d9-f091-444e-bce4-5379c487886f', 
                     '6b849aa8-0782-4c26-b7ac-a0f413f306c0', '253285d0-2057-4126-a212-f4b6155f010e', 
                     'd1d11ebe-b022-44aa-a211-3472483a4974', 'c7de0145-6be4-4677-9869-517a9016efcf', 
                     '2a7d9c47-fc56-4167-a5fc-5e40a8a5f5d5', 'b3245f5c-01b2-4d66-8aa7-a1cecfeeedf5', 
                     '7821fd56-97c3-4a9d-928a-3de2b31d42c9', '471e382d-bfbc-4ce9-bac0-9bf327fdba7e', 
                     'a38ab901-f302-4d65-a01e-d2fe6db160f7', '72d67b0f-0469-4026-b7a5-c0c0a9b8faff', 
                     'e23b4fcb-782b-4d5c-b962-94fd6018fef6', '4e42c1a9-d115-419e-81be-5c49ef51cd29', 
                     '098deac5-b810-4584-b277-10f8b5afe51d', 'd2c6e970-af35-41fe-9ba6-dc44a4187c67', 
                     '0ad76432-a736-4e37-9ffb-516df44291bc', 'c111218b-04db-4a5a-af50-aca9318791e0', 
                     '98da33d3-9455-497a-9703-a0f89c95a901', '9f936889-a757-419e-890a-d4cc1fa95e93', 
                     '724d41e3-f0ac-4254-a207-897ea3d42076', '2105d67e-495a-4202-b52a-af64602a1d1c', 
                     '17296190-84f5-4afd-93c5-2b79cfc8bc12', 'deb3a019-3544-4cde-9a75-9c3e2f00719d', 
                     '1d9bbe0d-7086-4fd0-b91c-ed6d196cb818', '22f1b8b1-347b-4dda-890c-2ea2555e2d4a', 
                     'c052a226-6141-4a13-b066-9daa499a4aa6', '1379131e-9b7f-40d9-a711-3749ccc50235', 
                     '2f04b2d4-94e6-40da-ac1b-8c4c76198ccd', '24550e9c-fb88-4c6f-8a7b-5c1d78f4e31f', 
                     '72197ca2-8209-49d6-ba10-7796b2e2e852', '6345ea41-c808-4cd0-884f-99a3001f8faa', 
                     '6be9b8dc-da05-47cc-bf15-04b88bff8209', '13019402-ff0f-4d6f-982e-1fa91ff4697a', 
                     '840033db-f0cb-4783-b0e0-8c9235d64948', '0d95dbf3-8615-4fee-bdca-3bb4f7f2f89a', 
                     'cf48f17a-eae7-4e8c-8e76-31c27393147c', '87de44f8-6bd2-4f21-8f14-470d8793104f', 
                     '1535f975-7d8c-4d3e-b3e6-1299ada51572', '12748606-5eb2-4c15-851e-6d896fd96135', 
                     '2c857ac6-3fb8-421d-bfd4-deeffa96df8f', '089b9649-44ce-41d6-8788-c584d58e7fa8', 
                     '1ca4e6ce-2bc8-40a9-bdf5-113449c3a172', 'e277c80f-b3ce-40d5-9a46-8c1e3a8dd1ba', 
                     '44e753af-6ee2-4d4a-b7dd-002261824bbc', '730b8507-0c36-4bcc-9e39-3fbaa55ff8a2', 
                     'afd27d8b-ed73-40cb-9efd-2a0fdabbd3df', '8f252755-fdd4-44cd-93d0-05bd161939e7', 
                     'e3a88932-c76e-4158-842c-d710a9856df1', 'd0b3e11e-68d8-4dbb-93a8-1b9746815ae5', 
                     '1ab03a28-2144-4c83-bb46-d0f814b56133', '79e496b9-c01e-4cf9-b07b-ab28dd5e3b70', 
                     '58e5a396-77c4-4ab6-b235-afe364c0580f', '82d4c783-5080-4faa-9cec-ba9152bc9fc8', 
                     'e4551f20-355f-428a-99dc-c3a84eec86d5', 'f79d71a3-929f-4f94-b4f4-e7c69a590216', 
                     'b775275c-acbf-40ff-b824-c675b80a68c5', '1f708d3c-4d86-4ab7-afdf-5741fe661744', 
                     '1e90ec38-0f85-442b-ac1b-ca687fa91d88', 'c116bc53-09e2-44c3-a147-593e1c69901e', 
                     'adde7db5-b29d-4ba5-8dae-6cd5e4f315f8', '60cedbef-3cea-42ee-a9c1-7a93d4277c34', 
                     '57798a1f-41d3-494f-b9fa-0537857d6789', '166f0d9d-df14-46ef-a7fb-40a57eb1c3e0', 
                     '7b478a01-ac9c-4189-a2de-12fa853baff7', '0cd7d7ae-166a-41b3-89bd-4726bee0c661', 
                     '30da7d42-5163-4ec9-81b6-25016c51d437', '8085b506-1a4e-40d7-be5e-c99288a9d638', 
                     '2693a492-c5b8-47ee-bfe3-1a674fdf3197', 'fe9c93dd-8aaf-47e1-8244-6c13704bebff', 
                     '5b9ae1cb-4b4a-4832-857f-7f32f0b19641', 'a7007fff-0752-4785-9a5f-2562665236d8', 
                     '67fd561a-db3f-4011-a6d4-8d676b0f0b57', '1471d392-569c-4e34-b0c2-e7c81e77059c', 
                     '690d4ea8-5832-4593-9bb8-f02f5a2f083a', 'b7c35459-8ec4-48d7-b734-87892c517ed1', 
                     '69912dd8-8e11-413f-83e6-cf6f70c949cf', '90ececf1-3fa4-48ad-9690-1a23ee0d2175' 
                    ],
		'RU-TYU' => ['9ae64229-9f7b-4149-b27a-d1f6ec74b5ce'],
		'RU-UD'  => ['d948319d-b151-48f5-9791-22ccfeeabfe7', 'deb1d05a-71ce-40d1-b726-6ba85d70d58f', 
                    'e69a280f-9064-490e-bae0-8bd39527872f', '7096d8a5-2b41-47b1-95ae-35efcbc07dee'
                    ],
		'RU-ULY' => ['73b29372-242c-42c5-89cd-8814bc2368af', 'bebfd75d-a0da-4bf9-8307-2e2c85eac463'],

		'RU-CHE' => ['f2976e80-32e1-4284-8eda-06cf19239cd1', '1fe59b79-b019-45d7-bfd9-03b3b2d49cb6', 
                     'a376e68d-724a-4472-be7c-891bdb09ae32', '988157bf-d6d5-4c2a-80ec-4ad531eea056', 
                     '110c731e-d72b-4c37-91cb-03ce33d9e727', 'dbca0fdd-89a6-43ad-9bd0-9796236917d7'
                    ],
		'RU-CU'  => ['dd8caeab-c685-4f2a-bf5f-550aca1bbc48', '6edd2a33-d03a-4d59-83c3-e14de6890a49', '32599307-3fe7-4cf4-8fee-640044422d68'],
		'RU-YAR' => ['6b1bab7d-ee45-4168-a2a6-4ce2880d90d3']
	];

	/* Поля объекта */
	protected $fields = [
		'amenity'         => 'atm',
		'ref'             => '',
		'name'            => '',
		'name:ru'         => '',
		'name:en'         => '',
		'operator'        => 'ПАО "АК БАРС" БАНК', // https://www.cbr.ru/banking_sector/credit/coinfo/?id=920000005
		'contact:website' => 'https://www.akbars.ru/',
		'contact:phone'   => '+7 800 2005303',
		'currency:RUB'    => 'yes',
		'cash_in'         => '',
        'description'     => '',
		'opening_hours'   => '',
		'lat'             => '',
		'lon'             => '',
		'_addr'           => '',
		'brand'           => 'Ак Барс Банк'
	];

	/* Фильтр для поиска объектов в OSM */
	protected $filter = [
		'[amenity=atm][operator~"Ак Барс",i]'
	];

	/* Обновление данных по региону */
	public function update()
	{
		foreach (static::$urls[$this->region] as $id) {

            $url = "https://www.akbars.ru/api/offices?cityFiasRef=$id&branchAtmMode=2&clientSegment=2";

            $page = $this->get_web_page($url);
            if (is_null($page)) {
                return;
            }
            $this->parse($page);
            usleep(500000);
		}
	}

	/* Парсер страницы */
	protected function parse($st)
	{
		$a = json_decode($st, true);
		if (is_null($a)) {
			return;
		}

		foreach ($a['atms'] as $obj) {
            $obj['lat'] = $obj['latitude'];
			$obj['lon'] = $obj['longitude'];
			$obj['_addr'] = $obj['fullAddress'];
            $obj['description'] = $obj['placeNote']; // добавить к перечню полей

			// Приём наличных
			if ($obj['service_CashIn'] == 'true') {
				$obj['cash_in'] = 'yes';
			}

			// Время работы
			if ($obj['workingHours'] == 'круглосуточно') {
				$obj['opening_hours'] = '24/7';
			} else {
				$obj['opening_hours'] = $this->time($obj['workingHours']);
			}

			$this->addObject($this->makeObject($obj));
		}
	}
}
