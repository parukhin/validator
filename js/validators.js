// validators.js v0.14
var osm = new osm_cl()

var regions = {
	'RU': {
		name: 'Россия',
	},
	'RU-AD': {
		name: 'Республика Адыгея',
	},
	'RU-AL': {
		name: 'Республика Алтай',
	},
	'RU-BA': {
		name: 'Республика Башкортостан',
	},
	'RU-BU': {
		name: 'Республика Бурятия',
	},
	'RU-DA': {
		name: 'Республика Дагестан',
	},
	'RU-IN': {
		name: 'Республика Ингушетия',
	},
	'RU-KB': {
		name: 'Кабардино-Балкарская республика',
	},
	'RU-KL': {
		name: 'Республика Калмыкия',
	},
	'RU-KC': {
		name: 'Карачаево-Черкесская республика',
	},
	'RU-KR': {
		name: 'Республика Карелия',
	},
	'RU-KO': {
		name: 'Республика Коми',
	},
	'RU-CR': {
		name: 'Республика Крым',
	},
	'RU-ME': {
		name: 'Республика Марий Эл',
	},
	'RU-MO': {
		name: 'Республика Мордовия',
	},
	'RU-SA': {
		name: 'Республика Саха (Якутия)',
	},
	'RU-SE': {
		name: 'Республика Северная Осетия - Алания',
	},
	'RU-TA': {
		name: 'Республика Татарстан',
	},
	'RU-TY': {
		name: 'Республика Тыва',
	},
	'RU-UD': {
		name: 'Удмуртская республика',
	},
	'RU-KK': {
		name: 'Республика Хакасия',
	},
	'RU-CE': {
		name: 'Чеченская республика',
	},
	'RU-CU': {
		name: 'Чувашская республика',
	},
	'RU-ALT': {
		name: 'Алтайский край',
	},
	'RU-ZAB': {
		name: 'Забайкальский край',
	},
	'RU-KAM': {
		name: 'Камчатский край',
	},
	'RU-KDA': {
		name: 'Краснодарский край',
	},
	'RU-KYA': {
		name: 'Красноярский край',
	},
	'RU-PER': {
		name: 'Пермский край',
	},
	'RU-PRI': {
		name: 'Приморский край',
	},
	'RU-STA': {
		name: 'Ставропольский край',
	},
	'RU-KHA': {
		name: 'Хабаровский край',
	},
	'RU-AMU': {
		name: 'Амурская область',
	},
	'RU-ARK': {
		name: 'Архангельская область',
	},
	'RU-AST': {
		name: 'Астраханская область',
	},
	'RU-BEL': {
		name: 'Белгородская область',
	},
	'RU-BRY': {
		name: 'Брянская область',
	},
	'RU-VLA': {
		name: 'Владимирская область',
	},
	'RU-VGG': {
		name: 'Волгоградская область',
	},
	'RU-VLG': {
		name: 'Вологодская область',
	},
	'RU-VOR': {
		name: 'Воронежская область',
	},
	'RU-IVA': {
		name: 'Ивановская область',
	},
	'RU-IRK': {
		name: 'Иркутская область',
	},
	'RU-KGD': {
		name: 'Калининградская область',
	},
	'RU-KLU': {
		name: 'Калужская область',
	},
	'RU-KEM': {
		name: 'Кемеровская область',
	},
	'RU-KIR': {
		name: 'Кировская область',
	},
	'RU-KOS': {
		name: 'Костромская область',
	},
	'RU-KGN': {
		name: 'Курганская область',
	},
	'RU-KRS': {
		name: 'Курская область',
	},
	'RU-LEN': {
		name: 'Ленинградская область',
	},
	'RU-LIP': {
		name: 'Липецкая область',
	},
	'RU-MAG': {
		name: 'Магаданская область',
	},
	'RU-MOS': {
		name: 'Московская область',
	},
	'RU-MUR': {
		name: 'Мурманская область',
	},
	'RU-NIZ': {
		name: 'Нижегородская область',
	},
	'RU-NGR': {
		name: 'Новгородская область',
	},
	'RU-NVS': {
		name: 'Новосибирская область',
	},
	'RU-OMS': {
		name: 'Омская область',
	},
	'RU-ORE': {
		name: 'Оренбургская область',
	},
	'RU-ORL': {
		name: 'Орловская область',
	},
	'RU-PNZ': {
		name: 'Пензенская область',
	},
	'RU-PSK': {
		name: 'Псковская область',
	},
	'RU-ROS': {
		name: 'Ростовская область',
	},
	'RU-RYA': {
		name: 'Рязанская область',
	},
	'RU-SAM': {
		name: 'Самарская область',
	},
	'RU-SAR': {
		name: 'Саратовская область',
	},
	'RU-SAK': {
		name: 'Сахалинская область',
	},
	'RU-SVE': {
		name: 'Свердловская область',
	},
	'RU-SMO': {
		name: 'Смоленская область',
	},
	'RU-TAM': {
		name: 'Тамбовская область',
	},
	'RU-TVE': {
		name: 'Тверская область',
	},
	'RU-TOM': {
		name: 'Томская область',
	},
	'RU-TUL': {
		name: 'Тульская область',
	},
	'RU-TYU': {
		name: 'Тюменская область',
	},
	'RU-ULY': {
		name: 'Ульяновская область',
	},
	'RU-CHE': {
		name: 'Челябинская область',
	},
	'RU-YAR': {
		name: 'Ярославская область',
	},
	'RU-MOW': {
		name: 'Москва',
	},
	'RU-SPE': {
		name: 'Санкт-Петербург',
	},
	'RU-SEV': {
		name: 'Севастополь',
	},
	'RU-YEV': {
		name: 'Еврейская автономная область',
	},
	'RU-NEN': {
		name: 'Ненецкий автономный округ',
	},
	'RU-KHM': {
		name: 'Ханты-Мансийский автономный округ - Югра',
	},
	'RU-CHU': {
		name: 'Чукотский автономный округ',
	},
	'RU-YAN': {
		name: 'Ямало-Ненецкий автономный округ',
	}
};

/* Список всех регионов
'RU', 'RU-AD', 'RU-AL', 'RU-BA', 'RU-BU', 'RU-DA', 'RU-IN', 'RU-KB', 'RU-KL', 'RU-KC', 'RU-KR', 'RU-KO', 'RU-CR', 'RU-ME', 'RU-MO', 'RU-SA', 'RU-SE', 'RU-TA', 'RU-TY', 'RU-UD', 'RU-KK', 'RU-CE', 'RU-CU', 'RU-ALT', 'RU-ZAB', 'RU-KAM', 'RU-KDA', 'RU-KYA', 'RU-PER', 'RU-PRI', 'RU-STA', 'RU-KHA', 'RU-AMU', 'RU-ARK', 'RU-AST', 'RU-BEL', 'RU-BRY', 'RU-VLA', 'RU-VGG', 'RU-VLG', 'RU-VOR', 'RU-IVA', 'RU-IRK', 'RU-KGD', 'RU-KLU', 'RU-KEM', 'RU-KIR', 'RU-KOS', 'RU-KGN', 'RU-KRS', 'RU-LEN', 'RU-LIP', 'RU-MAG', 'RU-MOS', 'RU-MUR', 'RU-NIZ', 'RU-NGR', 'RU-NVS', 'RU-OMS', 'RU-ORE', 'RU-ORL', 'RU-PNZ', 'RU-PSK', 'RU-ROS', 'RU-RYA', 'RU-SAM', 'RU-SAR', 'RU-SAK', 'RU-SVE', 'RU-SMO', 'RU-TAM', 'RU-TVE', 'RU-TOM', 'RU-TUL', 'RU-TYU', 'RU-ULY', 'RU-CHE', 'RU-YAR', 'RU-MOW', 'RU-SPE', 'RU-SEV', 'RU-YEV', 'RU-NEN', 'RU-KHM', 'RU-CHU', 'RU-YAN',
*/

var notes = {
	fuel: 'Дополнительные теги: shop, car_wash, cafe, toilets, compressed_air следует указывать отдельными точками внутри полигона amenity=fuel.'
};

var fields = {
	bank: ['_addr', 'ref', 'operator', 'branch', 'name', 'name:ru', 'name:en', 'official_name', 'contact:phone', 'contact:website', 'opening_hours', 'wheelchair', 'brand:wikidata', 'brand:wikipedia'],
	fuel: ['_addr', 'ref', 'operator', 'brand', 'name', 'name:ru', 'name:en', 'contact:phone', 'contact:website', 'opening_hours', 'shop', 'car_wash', 'cafe', 'toilets', 'compressed_air', 'internet_access', 'fuel:octane_100', 'fuel:octane_98', 'fuel:octane_95', 'fuel:octane_92', 'fuel:octane_80', 'fuel:diesel', 'fuel:lpg', 'fuel:cng', 'fuel:adblue', 'fuel:discount'],
	shop: ['_addr', 'ref', 'operator', 'name', 'name:ru', 'name:en', 'contact:phone', 'contact:website', 'opening_hours', 'shop', 'brand:wikidata', 'brand:wikipedia'],
	atm: ['_addr', 'ref', 'operator', 'branch', 'name', 'name:ru', 'name:en', 'contact:phone', 'contact:website', 'opening_hours', 'currency:RUB', 'currency:USD', 'currency:EUR', 'cash_in', 'brand:wikidata', 'brand:wikipedia'],
};

var validators = {
	gazpromneft: {
		name: 'Газпромнефть',
		note: notes.fuel,
		noteIsShow: true,
		link: 'https://www.gpnbonus.ru/our_azs/',
		fields: fields.fuel,
		regions: [
			'RU-MOW', 'RU-MOS', 'RU-SPE', 'RU-LEN', 'RU-ALT', 'RU-VLG', 'RU-VLA', 'RU-IVA', 'RU-IRK', 'RU-KLU', 'RU-KEM', 'RU-KIR',
			'RU-KOS', 'RU-KDA', 'RU-KYA', 'RU-KGN', 'RU-NIZ', 'RU-NGR', 'RU-NVS', 'RU-OMS', 'RU-PER', 'RU-PNZ', 'RU-PSK', 'RU-KR',
			'RU-KK',  'RU-RYA', 'RU-SAM', 'RU-SVE', 'RU-SMO', 'RU-TVE', 'RU-TUL', 'RU-TOM', 'RU-TYU', 'RU-KHM', 'RU-CHE', 'RU-YAN',
			'RU-YAR', 'RU-TA'
		]
	},
	russian_post: {
		name: 'Почта России',
		note: '',
		noteIsShow: false,
		link: 'https://www.pochta.ru/offices',
		fields: ['_addr', 'ref', 'operator', 'name', 'contact:website', 'contact:facebook', 'contact:vk', 'contact:phone', 'opening_hours', 'operator:wikidata', 'operator:wikipedia'],
		regions: [
			'RU-AD',  'RU-AL',  'RU-BA',  'RU-BU',  'RU-DA',  'RU-IN',  'RU-KB',  'RU-KL',  'RU-KC',  'RU-KR',  'RU-KO',  'RU-CR',
			'RU-ME',  'RU-MO',  'RU-SA',  'RU-SE',  'RU-TA',  'RU-TY',  'RU-UD',  'RU-KK',  'RU-CE',  'RU-CU',  'RU-ALT', 'RU-ZAB',
			'RU-KAM', 'RU-KDA', 'RU-KYA', 'RU-PER', 'RU-PRI', 'RU-STA', 'RU-KHA', 'RU-AMU', 'RU-ARK', 'RU-AST', 'RU-BEL', 'RU-BRY',
			'RU-VLA', 'RU-VGG', 'RU-VLG', 'RU-VOR', 'RU-IVA', 'RU-IRK', 'RU-KGD', 'RU-KLU', 'RU-KEM', 'RU-KIR', 'RU-KOS', 'RU-KGN',
			'RU-KRS', 'RU-LEN', 'RU-LIP', 'RU-MAG', 'RU-MOS', 'RU-MUR', 'RU-NIZ', 'RU-NGR', 'RU-NVS', 'RU-OMS', 'RU-ORE', 'RU-ORL',
			'RU-PNZ', 'RU-PSK', 'RU-ROS', 'RU-RYA', 'RU-SAM', 'RU-SAR', 'RU-SAK', 'RU-SVE', 'RU-SMO', 'RU-TAM', 'RU-TVE', 'RU-TOM',
			'RU-TUL', 'RU-TYU', 'RU-ULY', 'RU-CHE', 'RU-YAR', 'RU-MOW', 'RU-SPE', 'RU-SEV', 'RU-YEV', 'RU-NEN', 'RU-KHM', 'RU-CHU',
			'RU-YAN'
		]
	},
	rosneft: {
		name: 'Роснефть',
		note: notes.fuel,
		noteIsShow: true,
		link: 'https://rosneft-azs.ru/stations',
		fields: fields.fuel,
		regions: [
			'RU', 'RU-MOW', 'RU-SPE', 'RU-AD', 'RU-AL', 'RU-ALT', 'RU-ARK', 'RU-BEL', 'RU-BRY', 'RU-BU', 'RU-VLA', 'RU-VGG', 'RU-VOR',
			'RU-ZAB', 'RU-IVA', 'RU-IN', 'RU-IRK', 'RU-KB', 'RU-KLU', 'RU-KC', 'RU-KR', 'RU-KEM', 'RU-KOS', 'RU-KDA', 'RU-KYA', 'RU-KGN',
			'RU-KUR', 'RU-LEN', 'RU-LIP', 'RU-MO', 'RU-MOS', 'RU-MUR', 'RU-NIZ', 'RU-NGR', 'RU-NVS', 'RU-ORE', 'RU-ORL', 'RU-PNZ',
			'RU-PSK', 'RU-ROS', 'RU-RYA', 'RU-SAM', 'RU-SAR', 'RU-SVE', 'RU-SE', 'RU-SMO', 'RU-STA', 'RU-TAM', 'RU-TA', 'RU-TVE',
			'RU-TOM', 'RU-TUL', 'RU-TY', 'RU-UD', 'RU-ULY', 'RU-KK', 'RU-KHM', 'RU-CHE', 'RU-CE', 'RU-CU', 'RU-YAN', 'RU-YAR'
		]
	},

	bashneft: {
		name: 'Башнефть',
		note: notes.fuel,
		noteIsShow: true,
		link: 'https://www.bashneft-azs.ru/network_azs/',
		fields: fields.fuel,
		regions: [
			'RU-BEL', 'RU-VLA', 'RU-VGG', 'RU-VOR', 'RU-KDA', 'RU-KGN', 'RU-NIZ', 'RU-ORE',  'RU-BA', 'RU-DA',  'RU-ME',  'RU-MO',
			'RU-TA',  'RU-ROS', 'RU-RYA', 'RU-SAM', 'RU-SAR', 'RU-SVE', 'RU-SMO', 'RU-TAM',  'RU-UD', 'RU-ULY', 'RU-CHE', 'RU-CU'
		]
	},
	magnit: {
		name: 'Магнит',
		note: '',
		noteIsShow: false,
		link: 'https://magnit.ru/shops/',
		fields: fields.shop,
		regions: [
			'RU-ALT', 'RU-ARK', 'RU-AST', 'RU-BEL', 'RU-BRY', 'RU-VLA', 'RU-VGG', 'RU-VLG', 'RU-VOR', 'RU-IVA', 'RU-KLU', 'RU-KEM',
			'RU-KIR', 'RU-KOS', 'RU-KDA', 'RU-KYA', 'RU-KGN', 'RU-KRS', 'RU-LEN', 'RU-LIP', 'RU-MOW', 'RU-MOS', 'RU-MUR', 'RU-NIZ',
			'RU-NGR', 'RU-NVS', 'RU-OMS', 'RU-ORE', 'RU-ORL', 'RU-PNZ', 'RU-PER', 'RU-PSK', 'RU-AD',  'RU-BA',  'RU-KB',  'RU-KL',
			'RU-KC',  'RU-KR',  'RU-KO',  'RU-ME',  'RU-MO',  'RU-SE',  'RU-TA',  'RU-UD',  'RU-KK',  'RU-ROS', 'RU-RYA', 'RU-SAM',
			'RU-SPE', 'RU-SAR', 'RU-SVE', 'RU-SMO', 'RU-STA', 'RU-TAM', 'RU-TVE', 'RU-TOM', 'RU-TUL', 'RU-TYU', 'RU-ULY', 'RU-KHM',
			'RU-CHE', 'RU-CU',  'RU-YAN', 'RU-YAR'
		]
	},
	magnitgipermarket: {
		name: 'Семейный Магнит',
		note: '',
		noteIsShow: false,
		link: 'https://magnit.ru/shops/',
		fields: fields.shop,
		regions: [
			'RU-ALT', 'RU-ARK', 'RU-AST', 'RU-BEL', 'RU-BRY', 'RU-VLA', 'RU-VGG', 'RU-VLG', 'RU-VOR', 'RU-IVA', 'RU-KLU', 'RU-KEM',
			'RU-KIR', 'RU-KOS', 'RU-KDA', 'RU-KYA', 'RU-KGN', 'RU-KRS', 'RU-LEN', 'RU-LIP', 'RU-MOW', 'RU-MOS', 'RU-MUR', 'RU-NIZ',
			'RU-NGR', 'RU-NVS', 'RU-OMS', 'RU-ORE', 'RU-ORL', 'RU-PNZ', 'RU-PER', 'RU-PSK', 'RU-AD',  'RU-BA',  'RU-KB',  'RU-KL',
			'RU-KC',  'RU-KR',  'RU-KO',  'RU-ME',  'RU-MO',  'RU-SE',  'RU-TA',  'RU-UD',  'RU-KK',  'RU-ROS', 'RU-RYA', 'RU-SAM',
			'RU-SPE', 'RU-SAR', 'RU-SVE', 'RU-SMO', 'RU-STA', 'RU-TAM', 'RU-TVE', 'RU-TOM', 'RU-TUL', 'RU-TYU', 'RU-ULY', 'RU-KHM',
			'RU-CHE', 'RU-CU',  'RU-YAN', 'RU-YAR'
		]
	},
	magnitkosmetic: {
		name: 'Магнит Косметик',
		note: '',
		noteIsShow: false,
		link: 'https://magnit.ru/shops/',
		fields: fields.shop,
		regions: [
			'RU-ALT', 'RU-ARK', 'RU-AST', 'RU-BEL', 'RU-BRY', 'RU-VLA', 'RU-VGG', 'RU-VLG', 'RU-VOR', 'RU-IVA', 'RU-KLU', 'RU-KEM',
			'RU-KIR', 'RU-KOS', 'RU-KDA', 'RU-KYA', 'RU-KGN', 'RU-KRS', 'RU-LEN', 'RU-LIP', 'RU-MOW', 'RU-MOS', 'RU-MUR', 'RU-NIZ',
			'RU-NGR', 'RU-NVS', 'RU-OMS', 'RU-ORE', 'RU-ORL', 'RU-PNZ', 'RU-PER', 'RU-PSK', 'RU-AD',  'RU-BA',  'RU-KB',  'RU-KL',
			'RU-KC',  'RU-KR',  'RU-KO',  'RU-ME',  'RU-MO',  'RU-SE',  'RU-TA',  'RU-UD',  'RU-KK',  'RU-ROS', 'RU-RYA', 'RU-SAM',
			'RU-SPE', 'RU-SAR', 'RU-SVE', 'RU-SMO', 'RU-STA', 'RU-TAM', 'RU-TVE', 'RU-TOM', 'RU-TUL', 'RU-TYU', 'RU-ULY', 'RU-KHM',
			'RU-CHE', 'RU-CU',  'RU-YAN', 'RU-YAR'
		]
	},
	magnitpharmacy: {
		name: 'Магнит Аптека',
		note: '',
		noteIsShow: false,
		link: 'https://magnit.ru/shops/',
		fields: fields.shop,
		regions: [
			'RU-ALT', 'RU-ARK', 'RU-AST', 'RU-BEL', 'RU-BRY', 'RU-VLA', 'RU-VGG', 'RU-VLG', 'RU-VOR', 'RU-IVA', 'RU-KLU', 'RU-KEM',
			'RU-KIR', 'RU-KOS', 'RU-KDA', 'RU-KYA', 'RU-KGN', 'RU-KRS', 'RU-LEN', 'RU-LIP', 'RU-MOW', 'RU-MOS', 'RU-MUR', 'RU-NIZ',
			'RU-NGR', 'RU-NVS', 'RU-OMS', 'RU-ORE', 'RU-ORL', 'RU-PNZ', 'RU-PER', 'RU-PSK', 'RU-AD',  'RU-BA',  'RU-KB',  'RU-KL',
			'RU-KC',  'RU-KR',  'RU-KO',  'RU-ME',  'RU-MO',  'RU-SE',  'RU-TA',  'RU-UD',  'RU-KK',  'RU-ROS', 'RU-RYA', 'RU-SAM',
			'RU-SPE', 'RU-SAR', 'RU-SVE', 'RU-SMO', 'RU-STA', 'RU-TAM', 'RU-TVE', 'RU-TOM', 'RU-TUL', 'RU-TYU', 'RU-ULY', 'RU-KHM',
			'RU-CHE', 'RU-CU',  'RU-YAN', 'RU-YAR'
		]
	},
	/*magnitwholesale: {
		name: 'Магнит Опт',
		note: '',
		noteIsShow: false,
		link: 'https://magnit.ru/shops/',
		fields: fields.shop,
		regions: [
			'RU-ALT', 'RU-ARK', 'RU-AST', 'RU-BEL', 'RU-BRY', 'RU-VLA', 'RU-VGG', 'RU-VLG', 'RU-VOR', 'RU-IVA', 'RU-KLU', 'RU-KEM',
			'RU-KIR', 'RU-KOS', 'RU-KDA', 'RU-KYA', 'RU-KGN', 'RU-KRS', 'RU-LEN', 'RU-LIP', 'RU-MOW', 'RU-MOS', 'RU-MUR', 'RU-NIZ',
			'RU-NGR', 'RU-NVS', 'RU-OMS', 'RU-ORE', 'RU-ORL', 'RU-PNZ', 'RU-PER', 'RU-PSK', 'RU-AD',  'RU-BA',  'RU-KB',  'RU-KL',
			'RU-KC',  'RU-KR',  'RU-KO',  'RU-ME',  'RU-MO',  'RU-SE',  'RU-TA',  'RU-UD',  'RU-KK',  'RU-ROS', 'RU-RYA', 'RU-SAM',
			'RU-SPE', 'RU-SAR', 'RU-SVE', 'RU-SMO', 'RU-STA', 'RU-TAM', 'RU-TVE', 'RU-TOM', 'RU-TUL', 'RU-TYU', 'RU-ULY', 'RU-KHM',
			'RU-CHE', 'RU-CU',  'RU-YAN', 'RU-YAR'
		]
	},*/
	sberbank: {
		name: 'Сбербанк (отделения)',
		note: '',
		noteIsShow: false,
		link: 'https://www.sberbank.ru/ru/about/today/oib',
		fields: fields.bank,
		regions: [
			'RU-ZAB', 'RU-IRK', 'RU-BU',  'RU-SA',  'RU-NIZ', 'RU-VLA', 'RU-KIR', 'RU-MO',  'RU-ME',  'RU-CU',  'RU-TA',  'RU-KHA',
			'RU-PRI', 'RU-AMU', 'RU-SAK', 'RU-YEV', 'RU-MAG', 'RU-KAM', 'RU-CHU', 'RU-TYU', 'RU-OMS', 'RU-KHM', 'RU-YAN', 'RU-PER',
			'RU-KO',  'RU-UD',  'RU-MOW', 'RU-SAM', 'RU-ULY', 'RU-ORE', 'RU-SAR', 'RU-VGG', 'RU-AST', 'RU-PNZ', 'RU-YAR', 'RU-KOS',
			'RU-IVA', 'RU-VLG', 'RU-NEN', 'RU-ARK', 'RU-SPE', 'RU-LEN', 'RU-MUR', 'RU-KGD', 'RU-PSK', 'RU-NGR', 'RU-KR',  'RU-NVS',
			'RU-TOM', 'RU-KEM', 'RU-ALT', 'RU-AL',  'RU-KYA', 'RU-TY',  'RU-KK',  'RU-MOS', 'RU-TVE', 'RU-KLU', 'RU-BRY', 'RU-SMO',
			'RU-TUL', 'RU-RYA', 'RU-SVE', 'RU-CHE', 'RU-KGN', 'RU-BA',  'RU-VOR', 'RU-ORL', 'RU-LIP', 'RU-KRS', 'RU-BEL', 'RU-TAM',
			'RU-ROS', 'RU-KDA', 'RU-AD',  'RU-STA', 'RU-SE',  'RU-KB',  'RU-IN',  'RU-DA',  'RU-KC',  'RU-KL',  'RU-CE'
		]
	},
	sberbank_atm: {
		name: 'Сбербанк (банкоматы)',
		note: '',
		noteIsShow: false,
		link: 'https://www.sberbank.ru/ru/about/today/oib',
		fields: fields.atm,
		regions: [
			'RU-ZAB', 'RU-IRK', 'RU-BU',  'RU-SA',  'RU-NIZ', 'RU-VLA', 'RU-KIR', 'RU-MO',  'RU-ME',  'RU-CU',  'RU-TA',  'RU-KHA',
			'RU-PRI', 'RU-AMU', 'RU-SAK', 'RU-YEV', 'RU-MAG', 'RU-KAM', 'RU-CHU', 'RU-TYU', 'RU-OMS', 'RU-KHM', 'RU-YAN', 'RU-PER',
			'RU-KO',  'RU-UD',  'RU-MOW', 'RU-SAM', 'RU-ULY', 'RU-ORE', 'RU-SAR', 'RU-VGG', 'RU-AST', 'RU-PNZ', 'RU-YAR', 'RU-KOS',
			'RU-IVA', 'RU-VLG', 'RU-NEN', 'RU-ARK', 'RU-SPE', 'RU-LEN', 'RU-MUR', 'RU-KGD', 'RU-PSK', 'RU-NGR', 'RU-KR',  'RU-NVS',
			'RU-TOM', 'RU-KEM', 'RU-ALT', 'RU-AL',  'RU-KYA', 'RU-TY',  'RU-KK',  'RU-MOS', 'RU-TVE', 'RU-KLU', 'RU-BRY', 'RU-SMO',
			'RU-TUL', 'RU-RYA', 'RU-SVE', 'RU-CHE', 'RU-KGN', 'RU-BA',  'RU-VOR', 'RU-ORL', 'RU-LIP', 'RU-KRS', 'RU-BEL', 'RU-TAM',
			'RU-ROS', 'RU-KDA', 'RU-AD',  'RU-STA', 'RU-SE',  'RU-KB',  'RU-IN',  'RU-DA',  'RU-KC',  'RU-KL',  'RU-CE'
		]
	},
	velobike: {
		name: 'Велобайк',
		note: '',
		noteIsShow: false,
		link: 'http://velobike.ru/parkings/',
		fields: ['_addr', 'ref', 'capacity', 'operator', 'contact:email', 'contact:phone', 'contact:website'],
		regions: ['RU-MOW']
	},
	perekrestok: {
		name: 'Перекрёсток',
		note: '',
		noteIsShow: false,
		link: 'https://www.perekrestok.ru/shops/',
		fields: fields.shop,
		regions: [
			'RU-MOW', 'RU-ROS', 'RU-TA',  'RU-SAR', 'RU-MOS', 'RU-BEL', 'RU-NIZ', 'RU-VLA', 'RU-ME',  'RU-VOR', 'RU-LEN', 'RU-KDA',
			'RU-SVE', 'RU-KLU', 'RU-KRS', 'RU-LIP', 'RU-CHE', 'RU-STA', 'RU-TOM', 'RU-SAM', 'RU-TUL', 'RU-ORL', 'RU-ORE', 'RU-SPE',
			'RU-PNZ', 'RU-PER', 'RU-RYA', 'RU-MO',  'RU-KHM', 'RU-TAM', 'RU-TVE', 'RU-TYU', 'RU-ULY', 'RU-BA',  'RU-CU',  'RU-YAR',
			'RU'
		]
	},
	azbuka1: {
		name: 'Азбука Вкуса',
		note: '',
		noteIsShow: false,
		link: 'https://av.ru/shops/',
		fields: fields.shop,
		regions: ['RU-MOW', 'RU-MOS', 'RU-SPE', 'RU']
	},
	azbuka2: {
		name: 'АВ Daily',
		note: '',
		noteIsShow: false,
		link: 'https://av.ru/shops/',
		fields: fields.shop,
		regions: ['RU-MOW', 'RU-MOS', 'RU-SPE', 'RU']
	},
	azbuka3: {
		name: 'АВ Маркет',
		note: '',
		noteIsShow: false,
		link: 'https://av.ru/shops/',
		fields: fields.shop,
		regions: ['RU-MOW', 'RU-MOS', 'RU-SPE', 'RU']
	},
	azbuka4: {
		name: 'АВ Энотека',
		note: '',
		noteIsShow: false,
		link: 'https://av.ru/shops/',
		fields: fields.shop,
		regions: ['RU-MOW', 'RU-MOS', 'RU-SPE', 'RU']
	},
	pyaterochka: {
		name: 'Пятёрочка',
		note: '',
		noteIsShow: false,
		link: 'https://5ka.ru/stores/',
		fields: fields.shop,
		regions: [
			'RU-ARK', 'RU-AST', 'RU-BEL', 'RU-BRY', 'RU-VLA', 'RU-VGG', 'RU-VLG', 'RU-VOR', 'RU-IVA', 'RU-KLU', 'RU-KC',  'RU-KEM',
			'RU-KIR', 'RU-KOS', 'RU-KDA', 'RU-KGN', 'RU-KRS', 'RU-LEN', 'RU-LIP', 'RU-MOW', 'RU-MOS', 'RU-MUR', 'RU-NIZ', 'RU-NGR',
			'RU-OMS', 'RU-ORE', 'RU-ORL', 'RU-PNZ', 'RU-PER', 'RU-PSK', 'RU-AD',  'RU-BA',  'RU-DA',  'RU-KR',  'RU-KO',  'RU-ME',
			'RU-MO',  'RU-TA',  'RU-UD',  'RU-KK',  'RU-ROS', 'RU-RYA', 'RU-SAM', 'RU-SPE', 'RU-SAR', 'RU-SVE', 'RU-SMO', 'RU-STA',
			'RU-TAM', 'RU-TVE', 'RU-TUL', 'RU-TYU', 'RU-ULY', 'RU-KHM', 'RU-CHE', 'RU-CU',  'RU-YAR'
		]
	},
	diksi: {
		name: 'Дикси',
		note: '',
		noteIsShow: false,
		link: 'https://dixy.ru/nearest-shop/',
		fields: fields.shop,
		regions: [
			'RU-MOW', 'RU-MOS', 'RU-SPE', 'RU-LEN', 'RU-ARK', 'RU-KR',  'RU-VLG', 'RU-PSK', 'RU-NGR', 'RU-MUR', 'RU-TUL', 'RU-BRY',
			'RU-KLU', 'RU-SMO', 'RU-RYA', 'RU-ORL', 'RU-TAM', 'RU-LIP', 'RU-VLA', 'RU-IVA', 'RU-KOS', 'RU-YAR', 'RU-NIZ', 'RU-CHE',
			'RU-SVE', 'RU-TYU', 'RU-TVE', 'RU'
		]
	},
	lapy4: {
		name: 'Четыре лапы',
		note: '',
		noteIsShow: false,
		link: 'https://4lapy.ru/shops/',
		fields: ['_addr', 'ref', 'operator', 'name', 'name:ru', 'name:en', 'contact:phone', 'contact:website', 'opening_hours', 'shop', 'pets', 'aquarium', 'veterinary', 'grooming'],
		regions: [
			'RU-MOW', 'RU-MOS', 'RU-VLA', 'RU-VGG', 'RU-VOR', 'RU-IVA', 'RU-KLU', 'RU-KOS', 'RU-LIP', 'RU-NIZ', 'RU-TUL', 'RU-ORL',
			'RU-RYA', 'RU-TVE', 'RU-YAR', 'RU-TA', 'RU'
		]
	},
	alfabank: {
		name: 'Альфа-Банк (отделения)',
		note: '',
		noteIsShow: false,
		link: 'https://alfabank.ru/office/',
		fields: fields.bank,
		regions: [
			'RU-TUL', 'RU-ALT', 'RU-ARK', 'RU-BA',  'RU-BEL', 'RU-VLA', 'RU-VGG', 'RU-VOR', 'RU-IRK', 'RU-KGD', 'RU-KLU', 'RU-KR', 
			'RU-KEM', 'RU-KIR', 'RU-KDA', 'RU-KYA', 'RU-KGN', 'RU-KRS', 'RU-LIP', 'RU-ME',  'RU-MO',  'RU-MOS', 'RU-MOW', 'RU-MUR',
			'RU-NIZ', 'RU-NVS', 'RU-OMS', 'RU-ORE', 'RU-PNZ', 'RU-PER', 'RU-PRI', 'RU-PSK', 'RU-ROS', 'RU-RYA', 'RU-SAM', 'RU-SPE',
			'RU-LEN', 'RU-SAR', 'RU-SA',  'RU-SAK', 'RU-SVE', 'RU-STA', 'RU-TA',  'RU-TVE', 'RU-TOM', 'RU-TYU', 'RU-UD',  'RU-ULY',
			'RU-KHA', 'RU-KK',  'RU-KHM', 'RU-CHE', 'RU-CU',  'RU-YAR'
		]
	},
	alfabank_atm: {
		name: 'Альфа-Банк (банкоматы)',
		note: '',
		noteIsShow: false,
		link: 'https://alfabank.ru/office/',
		fields: fields.atm,
		regions: [
			'RU-TUL', 'RU-ALT', 'RU-ARK', 'RU-BA',  'RU-BEL', 'RU-VLA', 'RU-VGG', 'RU-VOR', 'RU-IRK', 'RU-KGD', 'RU-KLU', 'RU-KR', 
			'RU-KEM', 'RU-KIR', 'RU-KDA', 'RU-KYA', 'RU-KGN', 'RU-KRS', 'RU-LIP', 'RU-ME',  'RU-MO',  'RU-MOS', 'RU-MOW', 'RU-MUR',
			'RU-NIZ', 'RU-NVS', 'RU-OMS', 'RU-ORE', 'RU-PNZ', 'RU-PER', 'RU-PRI', 'RU-PSK', 'RU-ROS', 'RU-RYA', 'RU-SAM', 'RU-SPE',
			'RU-LEN', 'RU-SAR', 'RU-SA',  'RU-SAK', 'RU-SVE', 'RU-STA', 'RU-TA',  'RU-TVE', 'RU-TOM', 'RU-TYU', 'RU-UD',  'RU-ULY',
			'RU-KHA', 'RU-KK',  'RU-KHM', 'RU-CHE', 'RU-CU',  'RU-YAR'
		]
	},
	kenguru: {
		name: 'Кенгуру',
		note: '',
		noteIsShow: false,
		link: 'http://kenguru.ru/info/shops.php',
		fields: fields.shop,
		regions: ['RU-IVA', 'RU-YAR', 'RU-VLA', 'RU-KOS', 'RU-MOS', 'RU-MOW']
	},
	lukoil: {
		name: 'Лукойл',
		note: notes.fuel,
		noteIsShow: true,
		link: 'https://auto.lukoil.ru/ru/ProductsAndServices/PetrolStations',
		fields: fields.fuel,
		regions: [
			'RU-AD', 'RU-BA', 'RU-KB', 'RU-KL', 'RU-KC', 'RU-KR', 'RU-KO', 'RU-ME', 'RU-MO', 'RU-SE', 'RU-TA', 'RU-UD', 'RU-CE',
		 	'RU-CU', 'RU-ALT', 'RU-KDA', 'RU-KYA', 'RU-PER', 'RU-STA', 'RU-ARK', 'RU-AST', 'RU-BEL', 'RU-BRY', 'RU-VLA', 'RU-VGG', 
			'RU-VLG', 'RU-VOR', 'RU-IVA', 'RU-KGD', 'RU-KLU', 'RU-KEM', 'RU-KIR', 'RU-KOS', 'RU-KGN', 'RU-KRS', 'RU-LEN', 'RU-LIP', 
			'RU-MOS', 'RU-MUR', 'RU-NIZ', 'RU-NGR', 'RU-NVS', 'RU-OMS', 'RU-ORE', 'RU-ORL', 'RU-PNZ', 'RU-PSK', 'RU-ROS', 'RU-RYA', 
			'RU-SAM', 'RU-SAR', 'RU-SVE', 'RU-SMO', 'RU-TAM', 'RU-TVE', 'RU-TUL', 'RU-TYU', 'RU-ULY', 'RU-CHE', 'RU-YAR', 'RU-MOW', 
			'RU-SPE', 'RU-NEN', 'RU-KHM', 'RU-YAN'
		]
	},
	mkb: {
		name: 'Московский кредитный банк (отделения)',
		note: '',
		noteIsShow: false,
		link: 'https://mkb.ru/about/address/branch',
		fields: fields.bank,
		regions: ['RU', 'RU-MOW', 'RU-MOS']
	},
	mkb_atm: {
		name: 'Московский кредитный банк (банкоматы)',
		note: '',
		noteIsShow: false,
		link: 'https://mkb.ru/about/address/atm',
		fields: fields.atm,
		regions: ['RU', 'RU-MOW', 'RU-MOS']
	},
	temples: {
		name: 'Церкви (temples.ru)',
		note: '',
		noteIsShow: false,
		link: 'http://www.temples.ru/tree.php',
		fields: ['_addr', 'ref:temples.ru', 'building', 'name', 'alt_name', 'religion', 'denomination', 'denomination:ru', 'russian_orthodox', 'disused', 'community:gender', 'start_date', 'contact:website', '_id'],
		regions: [
			'RU-ALT', 'RU-AMU', 'RU-ARK', 'RU-AST', 'RU-BEL', 'RU-VLA', 'RU-VGG', 'RU-VLG', 'RU-VOR', 'RU-ZAB', 'RU-IVA', 'RU-IRK',
			'RU-KGD', 'RU-KLU', 'RU-KAM', 'RU-KC',  'RU-KEM', 'RU-KIR', 'RU-KOS', 'RU-KDA', 'RU-KYA', 'RU-KGN', 'RU-KRS', 'RU-LEN',
			'RU-LIP', 'RU-MAG', 'RU-MOW', 'RU-MOS', 'RU-MUR', 'RU-NIZ', 'RU-NGR', 'RU-NVS', 'RU-OMS', 'RU-ORE', 'RU-ORL', 'RU-PNZ',
			'RU-PER', 'RU-PRI', 'RU-PSK', 'RU-AD',  'RU-AL',  'RU-BA',  'RU-BU',  'RU-DA',  'RU-IN',  'RU-KL',  'RU-KR',  'RU-KO',
			'RU-CR',  'RU-ME',  'RU-MO',  'RU-SA',  'RU-SE',  'RU-TA',  'RU-TY',  'RU-KK',  'RU-ROS', 'RU-RYA', 'RU-SAM', 'RU-SPE',
			'RU-SAR', 'RU-SAK', 'RU-SVE', 'RU-SEV', 'RU-SMO', 'RU-STA', 'RU-TAM', 'RU-TVE', 'RU-TOM', 'RU-TUL', 'RU-TYU', 'RU-UD',
			'RU-ULY', 'RU-KHA', 'RU-CHE', 'RU-CE',  'RU-CU',  'RU-CHU', 'RU-YAR'
		]
	},
	moscow_parkomats: {
		name: 'Паркоматы',
		note: '',
		noteIsShow: false,
		link: 'https://data.mos.ru/opendata/1421',
		fields: ['_addr', 'ref', 'ref:mos_parking', 'zone:parking', 'vending', 'operator', 'contact:website' ,'contact:phone', 'opening_hours', 'payment:cash', 'payment:credit_cards', 'payment:debit_cards'],
		regions: ['RU-MOW']
	},
	burgerking: {
		name: 'Бургер Кинг',
		note: '',
		noteIsShow: false,
		link: 'https://burgerkingrus.ru/restaurants',
		fields: ['_addr', 'ref', 'name', 'name:ru', 'name:en', 'operator', 'cuisine', 'diet:vegetarian', 'drive_through', 'brand', 'contact:website', 'contact:phone', 'contact:email', 'contact:facebook', 'wheelchair', 'opening_hours', 'internet_access', 'internet_access:fee', 'brand:wikipedia', 'operator:wikidata'],
		regions: ['RU']
	},
	taifnk: {
		name: 'ТАИФ-НК',
		note: '',
		noteIsShow: false,
		link: 'https://taifazs.ru/map/list-gs/',
		fields: fields.fuel,
		regions: ['RU-TA', 'RU-SAM', 'RU-UD', 'RU-ULY', 'RU-CU', 'RU-KIR'] 
	},
	tatneft: {
		name: 'Татнефть',
		note: '',
		noteIsShow: false,
		link: 'https://azs.tatneft.ru/locator',
		fields: fields.fuel,
		regions: [
			'RU-AL', 'RU-BA', 'RU-ME', 'RU-MO', 'RU-TA', 'RU-UD', 'RU-CU', 'RU-KDA', 'RU-STA', 'RU-ARK', 'RU-BEL', 'RU-VLA', 'RU-VGG', 'RU-VLG',
			'RU-VOR', 'RU-KEM', 'RU-KGN', 'RU-LEN', 'RU-LIP', 'RU-MOS', 'RU-NIZ', 'RU-NGR', 'RU-OMS', 'RU-ORE', 'RU-PNZ', 'RU-PSK',
			'RU-ROS', 'RU-RYA', 'RU-SAM', 'RU-SVE', 'RU-SMO', 'RU-TVE', 'RU-TOM', 'RU-TUL', 'RU-ULY', 'RU-CHE', 'RU-YAR', 'RU-SPE', 'RU-MOW'] 
	},
	farmlend: {
		name: 'Фармленд',
		note: '',
		noteIsShow: false,
		link: 'https://farmlend.ru/page/apteki-na-karte',
		fields: fields.shop,
		regions: [
			'RU-BA', 'RU-TA', 'RU-UD', 'RU-MOS', 'RU-ORE', 'RU-SAM', 'RU-SVE', 'RU-TYU', 'RU-CHE', 'RU-MOW']
	},
	akbarsbank_atm: {
		name: 'Ак Барс (банкоматы)',
		note: '',
		noteIsShow: false,
		link: 'https://www.akbars.ru/offices/',
		fields: fields.atm,
		regions: [
			'RU-BU', 'RU-ALT', 'RU-BA', 'RU-KIR', 'RU-KDA', 'RU-KYA', 'RU-ME',  'RU-MO',  'RU-MOS', 'RU-MOW', 
			'RU-NGR', 'RU-NIZ', 'RU-NVS', 'RU-OMS', 'RU-ORE', 'RU-PER', 'RU-PSK', 'RU-SAM', 'RU-SPE', 'RU-LEN', 
			'RU-SAR', 'RU-SVE', 'RU-STA', 'RU-TA',  'RU-TYU', 'RU-UD',  'RU-ULY', 'RU-CHE', 'RU-CU',  'RU-YAR'
		]
	},
	kazan_parkomats: {
		name: 'Паркоматы Казань',
		note: '',
		noteIsShow: false,
		link: 'https://parkingkzn.ru/ru/',
		fields: ['_addr', 'ref', 'vending', 'operator', 'contact:website' ,'contact:phone', 'opening_hours', 'payment:credit_cards'],
		regions: ['RU-TA']
	},
	teboil: {
		name: 'Teboil',
		note: '',
		noteIsShow: false,
		link: 'https://azs.teboil.ru/map/',
		fields: fields.fuel,
		regions: ['RU'] 
	},
	nsp: {
		name: 'NSP',
		note: '',
		noteIsShow: false,
		link: 'https://nonstoppower.ru/dlya-polzovatelej/',
		fields: fields.fuel,
		regions: ['RU-TA']
	},
	vtb: {
		name: 'ВТБ (отделения)',
		note: '',
		noteIsShow: false,
		link: 'https://online.vtb.ru/map/offices',
		fields: fields.bank,
		regions: ['RU', 'RU-BA', 'RU-CU', 'RU-ME', 'RU-TA', 'RU-NIZ', 'RU-MOW', 'RU-MOS', 'RU-LEN', 'RU-SPE', 'RU-ULY']
	},
	finsb: {
		name: 'Финсервис (отделения)',
		note: '',
		noteIsShow: false,
		link: 'https://www.finsb.ru/about/offices/',
		fields: fields.bank,
		regions: ['RU']
	},
	finsb_atm: {
		name: 'Финсервис (банкоматы)',
		note: '',
		noteIsShow: false,
		link: 'https://www.finsb.ru/about/offices/',
		fields: fields.atm,
		regions: ['RU']
	},
	irbis: {
		name: 'Irbis',
		note: '',
		noteIsShow: false,
		link: 'https://taifazs.ru/map/list-gs/',
		fields: fields.fuel,
		regions: ['RU-BA', 'RU-ME', 'RU-NIZ', 'RU-SAM', 'RU-TA', 'RU-VLA', 'RU']
	},
	rshb: {
		name: 'Россельхозбанк (отделения)',
		note: '',
		noteIsShow: false,
		link: 'https://www.rshb.ru/natural/offices',
		fields: fields.bank,
		regions: [
			'RU-ALT', 'RU-AMU', 'RU-ARK', 'RU-BA', 'RU-BEL', 'RU-BRY', 'RU-BU', 'RU-VLA', 'RU-VGG', 'RU-VOR',
			'RU-DA', 'RU-IVA', 'RU-IRK', 'RU-KB', 'RU-KGD', 'RU-KLU', 'RU-KAM', 'RU-KEM', 'RU-KIR', 'RU-KO',
			'RU-KOS', 'RU-KDA', 'RU-KYA', 'RU-KUR', 'RU-LIP', 'RU-ME', 'RU-MO', 'RU-MOS', 'RU-MOW', 'RU-NIZ',
			'RU-NVS', 'RU-OMS', 'RU-ORE', 'RU-ORL', 'RU-PNZ', 'RU-PER', 'RU-PRI', 'RU-PSK', 'RU-ROS', 'RU-RYA',
			'RU-SAM', 'RU-SPE',	'RU-SAR', 'RU-SAK', 'RU-SVE', 'RU-SMO', 'RU-STA', 'RU-TAM', 'RU-TA', 'RU-TVE',
			'RU-TOM', 'RU-TY', 'RU-TUL', 'RU-TYU', 'RU-UD', 'RU-ULY', 'RU-KHA', 'RU-CHE', 'RU-CE', 'RU-ZAB',
			'RU-CU', 'RU-SA', 'RU-YAR'
		]
	},
	rshb_atm: {
		name: 'Россельхозбанк (банкоматы)',
		note: '',
		noteIsShow: false,
		link: 'https://www.rshb.ru/natural/atms',
		fields: fields.atm,
		regions: [
			'RU-ALT', 'RU-AMU', 'RU-ARK', 'RU-BA', 'RU-BEL', 'RU-BRY', 'RU-BU', 'RU-VLA', 'RU-VGG', 'RU-VOR',
			'RU-DA', 'RU-IVA', 'RU-IRK', 'RU-KB', 'RU-KGD', 'RU-KLU', 'RU-KAM', 'RU-KEM', 'RU-KIR', 'RU-KO',
			'RU-KOS', 'RU-KDA', 'RU-KYA', 'RU-KUR', 'RU-LIP', 'RU-ME', 'RU-MO', 'RU-MOS', 'RU-MOW', 'RU-NIZ',
			'RU-NVS', 'RU-OMS', 'RU-ORE', 'RU-ORL', 'RU-PNZ', 'RU-PER', 'RU-PRI', 'RU-PSK', 'RU-ROS', 'RU-RYA',
			'RU-SAM', 'RU-SPE',	'RU-SAR', 'RU-SAK', 'RU-SVE', 'RU-SMO', 'RU-STA', 'RU-TAM', 'RU-TA', 'RU-TVE',
			'RU-TOM', 'RU-TY', 'RU-TUL', 'RU-TYU', 'RU-UD', 'RU-ULY', 'RU-KHA', 'RU-CHE', 'RU-CE', 'RU-ZAB',
			'RU-CU', 'RU-SA', 'RU-YAR'
		]
	},
	rigla: {
		name: 'Ригла',
		note: '',
		noteIsShow: false,
		link: 'https://www.rigla.ru/pharmacies?filter=brands__1',
		fields: fields.shop,
		regions: [
			'RU-ALT', 'RU-AMU', 'RU-ARK', 'RU-AST', 'RU-BEL', 'RU-BRY', 'RU-VLA', 'RU-VGG', 
			'RU-VLG', 'RU-VOR', 'RU-YEV', 'RU-ZAB', 'RU-IVA', 'RU-IRK', 'RU-KGD', 'RU-KAL', 
			'RU-KAM', 'RU-KIR', 'RU-KOS', 'RU-KDA', 'RU-KYA', 'RU-KRS', 'RU-LIP', 'RU-MOS', 
			'RU-MOW', 'RU-MUR', 'RU-NIZ', 'RU-NGR', 'RU-ORE', 'RU-ORL', 'RU-PNZ', 'RU-PRI', 
			'RU-PSK', 'RU-AD', 'RU-BA', 'RU-BU', 'RU-DA', 'RU-KC', 'RU-KR', 'RU-KO', 'RU-ME', 
			'RU-TA', 'RU-ROS', 'RU-RYA', 'RU-SAM', 'RU-SAR', 'RU-SMO', 'RU-TAM', 'RU-TVE', 
			'RU-TOM', 'RU-TUL', 'RU-TYU', 'RU-KHM', 'RU-CHE', 'RU-CU', 'RU-YAN', 'RU-YAR', 
			'RU-SPE', 'RU-LEN', 'RU-CR', 'RU-SEV'
		]
	},
	budzdorov: {
		name: 'Будь здоров!',
		note: '',
		noteIsShow: false,
		link: 'https://www.rigla.ru/pharmacies?filter=brands__5',
		fields: fields.shop,
		regions: [
			'RU-ALT', 'RU-AMU', 'RU-ARK', 'RU-AST', 'RU-BEL', 'RU-BRY', 'RU-VLA', 'RU-VGG', 
			'RU-VLG', 'RU-VOR', 'RU-YEV', 'RU-ZAB', 'RU-IVA', 'RU-IRK', 'RU-KGD', 'RU-KAL', 
			'RU-KAM', 'RU-KIR', 'RU-KOS', 'RU-KDA', 'RU-KYA', 'RU-KRS', 'RU-LIP', 'RU-MOS', 
			'RU-MOW', 'RU-MUR', 'RU-NIZ', 'RU-NGR', 'RU-ORE', 'RU-ORL', 'RU-PNZ', 'RU-PRI', 
			'RU-PSK', 'RU-AD', 'RU-BA', 'RU-BU', 'RU-DA', 'RU-KC', 'RU-KR', 'RU-KO', 'RU-ME', 
			'RU-TA', 'RU-ROS', 'RU-RYA', 'RU-SAM', 'RU-SAR', 'RU-SMO', 'RU-TAM', 'RU-TVE', 
			'RU-TOM', 'RU-TUL', 'RU-TYU', 'RU-KHM', 'RU-CHE', 'RU-CU', 'RU-YAN', 'RU-YAR', 
			'RU-SPE', 'RU-LEN', 'RU-CR', 'RU-SEV'
		]
	},
	zdravcity: {
		name: 'Здравсити',
		note: '',
		noteIsShow: false,
		link: 'https://www.rigla.ru/pharmacies?filter=brands__7',
		fields: fields.shop,
		regions: [
			'RU-ALT', 'RU-AMU', 'RU-ARK', 'RU-AST', 'RU-BEL', 'RU-BRY', 'RU-VLA', 'RU-VGG', 
			'RU-VLG', 'RU-VOR', 'RU-YEV', 'RU-ZAB', 'RU-IVA', 'RU-IRK', 'RU-KGD', 'RU-KAL', 
			'RU-KAM', 'RU-KIR', 'RU-KOS', 'RU-KDA', 'RU-KYA', 'RU-KRS', 'RU-LIP', 'RU-MOS', 
			'RU-MOW', 'RU-MUR', 'RU-NIZ', 'RU-NGR', 'RU-ORE', 'RU-ORL', 'RU-PNZ', 'RU-PRI', 
			'RU-PSK', 'RU-AD', 'RU-BA', 'RU-BU', 'RU-DA', 'RU-KC', 'RU-KR', 'RU-KO', 'RU-ME', 
			'RU-TA', 'RU-ROS', 'RU-RYA', 'RU-SAM', 'RU-SAR', 'RU-SMO', 'RU-TAM', 'RU-TVE', 
			'RU-TOM', 'RU-TUL', 'RU-TYU', 'RU-KHM', 'RU-CHE', 'RU-CU', 'RU-YAN', 'RU-YAR', 
			'RU-SPE', 'RU-LEN', 'RU-CR', 'RU-SEV'
		]
	}
	// vtb-atm: {
	// 	name: 'ВТБ (банкоматы)',
	// 	note: '',
	// 	noteIsShow: false,
	// 	link: 'https://online.vtb.ru/map/atm',
	// 	fields: fields.atm,
	// 	regions: ['RU']
	// }
	/* krasnoeibeloe: {
		name: 'Красное & белое',
		note: '',
		noteIsShow: false,
		link: 'https://krasnoeibeloe.ru/address/',
		fields: fields.shop,
		regions: ['RU-IVA']
	} */


	/*
	validator: {                  // имя валидатора (совпадает с .php)
		name: 'name',             // название валидатора
		note: 'message',          // сообщение пользователю
		noteIsShow: true,         // показ сообщения (true / false)
		link: '',                 // ссылка на страницу источника данных
		fields: [],               // поля валидатора
		regions: ['RU', 'RU-BEL'] // список поддерживаемых регионов
	},
	*/
};

// wiki_places note: <b>Внимание!</b> Если вы меняете тег place или name на точке, поменяйте его <a href="/places/errors/">также и на контуре</a>!

C_Empty = 1;
C_Skip = 2;
C_Diff = 3;
C_Equal = 4;
C_Similar = 14;
C_NoCoords = 5;
C_NotFound = 6;
C_FoundRef = 7;
C_Double = 8;
C_Excess = 9;
C_Total = 0;

function osm_cl() {
	this._filter = { page: 0 };
	this._fast_filter = {};
	this._fast_filter_enable = 0;
	this._fast_filter_search_osm = 0;
	this._cityList = null;
	this.activeRegion = '';
	this.activeValidator = '';
	this.numPerPage = 30;

	// Формируем список регионов, для которых есть хотя бы один валидатор
	this.regions = function () {
		var st = '';

		for (region in regions) {
			regions[region].validators = [];
			for (validator in validators) { // если есть валидатор
				if (validators[validator].regions.indexOf(region) != -1) { // с поддержкой данного региона
					option = '<option value="' + region + '">' + regions[region]['name'] + '</option>'; // записываем опцию
					regions[region].validators[validator] = {};
				}
			}
			st += option;
		}

		if (st) {
			st = '<select id="region" onchange="osm.changeRegion(this.value)">' + '<option value="">Выберите регион</option>' + st + '</select>';
		}

		$('regions', st);
	}

	// Cмена региона
	this.changeRegion = function (x) {
		if (!regions[x]) return;
		this.activeRegion = x;
		document.location = '#' + x;
		$('validators', x ? osm.validators(x) : '');
		this._filter = { page: 0 };

		if (regions[x].validators[this.activeValidator] == undefined) { // если валидатор не поддерживает текущий регион или не выбран
			for (validator in regions[x].validators) {
				this.activeValidator = validator; // берём первый из списка доступных
				break;
			}
		}

		this.changeValidator(this.activeValidator);
		style($$('div.hidden'), 'display: block');
	}

	// select список валидаторов региона
	this.validators = function (region) {
		var st = '';
		for (validator in regions[region].validators) {
			st += '<option value="' + validator + '">' + validators[validator].name + '</option>';
		}
		if (st) {
			st = '<select id="validator" onchange="osm.changeValidator(this.value)">' + st + '</select>';
		}
		return st;
	}

	// смена валидатора
	this.changeValidator = function (x) {
		if (!regions[this.activeRegion].validators[x]) return;

		this.activeValidator = x;
		if ($('validator').value != x) $('validator').value = x;

		document.location = '#' + this.activeRegion + '/' + x;
		$('search').value = '';
		$('validate', '');

		this.update_note();

		this.update_state();

		this.loaded_objects = {};

		style('btn_revalidate', 'display: inline');

		this.validate(this.activeRegion, x);

	}

	// Обновление уведомления
	this.update_note = function () {
		if (validators[this.activeValidator].noteIsShow == true) {
			st = validators[this.activeValidator].note;
			$('note', st);
			style('note', 'display: block');
		} else {
			style('note', 'display: none');
		}
	}

	// Загрузка информации о времени запуска валидаторов
	this.load_state = function (force) {
		if (force === undefined) {
			force = false;
		}

		this.stateIsLoad = false;

		var url = '/data/state.json';
		if (force) {
			url += '?' + new Date().getTime()
		}

		axios.get(url)
			.then(function (response) {
				this.state.length = 0;
				this.state = response.data;
				osm.stateIsLoad = true;
				osm.update_state();
			})
			.catch(function (error) {
				console.log(error);
			});
	}

	// Обновление информации о времени запуска валидаторов
	this.update_state = function () {
		if (this.stateIsLoad) {

			var _ = function (x, y, z) {
				if ((x + '.' + y) in this.state) {
					return this.state[x + '.' + y][z] ? '<span title="' + date('H:i:s', this.state[x + '.' + y][z]) + '">' + date('d.m.Y', this.state[x + '.' + y][z]) + '</span>' : '?';
				} else {
					return '?';
				}
			}

			var st = '';
			st = 'Обновлено ' + _(this.activeRegion, this.activeValidator, 2) + ', OSM данные от ' + _(this.activeRegion, this.activeValidator, 3) +
				', <a href="' + validators[this.activeValidator].link + '" target=_blank>объекты</a> от ' + _(this.activeRegion, this.activeValidator, 4);
			$('date', st);
		}
	}

	// хэш функция по координтам
	this.hash = function (lat, lon) {
		lat = Math.round(parseFloat(lat));
		lon = Math.round(parseFloat(lon));
		return '' + lat + '' + lon;
	}

	// Генерация таблицы валидатора
	this.validate = function (region, validator) {
		$('validate', '');

		this.osm_data = {};
		this.real_data = [];
		this.osm_data_by_ref = {};

		this.log('Загрузка данных с сервера...');

		// Получаем новое время для принудительной загрузки .json
		var time = new Date().getTime();

		// Загрузка данных OSM
		axios.get('/data/' + region + '/' + validator + '_osm.json?' + time)
			.then(function (response) {
				for (i = 0; i < response.data.length; i++) {

					hash = osm.hash(response.data[i].lat, response.data[i].lon); // берем хэш от координат, чтобы было легко найти
					if (!osm.osm_data[hash]) {
						osm.osm_data[hash] = [];
					}
					osm.osm_data[hash].push(response.data[i]);

					// индекс по ref
					if (response.data[i].ref) {
						osm.osm_data_by_ref[response.data[i].ref] = { hash: hash, id: osm.osm_data[hash].length - 1 };
					}
				}
				osm.revalidate();
			})
			.catch(function (error) {
				osm.log('Данные отсутствуют, необходимо запустить валидатор.');
			});

		// Загрузка реальных данных
		axios.get('/data/' + region + '/' + validator + '_real.json?' + time)
			.then(function (response) {
				osm.real_data = osm.real_data.concat(response.data);
				osm.revalidate();
			})
			.catch(function (error) {
				osm.log('Данные отсутствуют, необходимо запустить валидатор.');
			});
	}

	// Функция генерации таблицы валидатора
	this.revalidate = function () {
		if (this.timerRevalidate) clearInterval(this.timerRevalidate);
		this.timerRevalidate = setTimeout(function () { osm.revalidate_(); }, 200);
	}

	// Валидация подсчет кол-ва объектов
	this.revalidate_ = function () {
		var a = osm.real_data, osm_data, state, i, j, t;
		this.count = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

		this.log('Обработка данных...');

		this._fast_filter = {};

		// вспомогательная функция регистрации быстрого фильтра
		var _ = function (a, x) {
			if (a && a[x]) {
				if (!osm._fast_filter[x]) osm._fast_filter[x] = {};
				osm._fast_filter[x][a[x]] = 1 + (osm._fast_filter[x][a[x]] || 0);
			}
		};

		if (a[0] != false) { // если данные есть
			for (i = 0; i < a.length; i++) {
				osm_data = osm.search(a[i], true);

				if (!osm_data) {
					a[i]._state = a[i].lat ? C_NotFound : C_NoCoords;
				} else {
					if (osm_data._used > 1) {
						a[i]._double = C_Double; // дубликат
					}
					if (!a[i].lat) {
						a[i]._ref = C_FoundRef; this.count[C_FoundRef]++;
					};

					a[i]._state = 0;

					for (field in validators[this.activeValidator].fields) {
						state = osm.compareField(osm_data, a[i], validators[this.activeValidator].fields[field]);

						if (state == C_Skip) continue;
						if (state == C_Diff) { a[i]._state = state; break; }
						if (state == C_Empty)
							if (!a[i]._state) a[i]._state = state;
					}
					if (!a[i]._state) a[i]._state = C_Equal;
					if (osm_data._used > 1)
						this.count[C_Double] = (this.count[C_Double] || 0) + 1;
				}

				this.count[a[i]._state] = (this.count[a[i]._state] || 0) + 1;
				this.count[C_Total]++;

				// формируем быстрый фильтр
				t = this._fast_filter_search_osm ? osm_data : a[i];
				_(t, 'place');
				_(t, 'addr:district');
				_(t, 'official_status');
				_(t, 'operator');
				_(t, 'brand');
				_(t, 'branch');
				_(t, 'department');
				_(t, 'building');
				_(t, 'denomination');
				if (osm.activeValidator != 'wiki_places')
					if (osm.activeValidator != 'temples')
						_(t, 'website');
				if (osm.activeValidator != 'russian_post')
					if (osm.activeValidator != 'wiki_places')
						if (osm.activeValidator != 'temples')
							_(t, 'name');
			}
		}

		// Подсчёт количества непривязанных OSM объектов
		for (i in this.osm_data) {
			for (j in this.osm_data[i]) {
				if (!this.osm_data[i][j]._used) {
					this.count[C_Excess]++;
				}
			}
		}

		osm._cityList = null;

		// открываем объекты с ошибкой
		if (this.count[C_Diff]) this.filter({ _state: C_Diff });
		else
			if (this.count[C_Empty]) this.filter({ _state: C_Empty });
			else
				if (this.count[C_NotFound]) this.filter({ _state: C_NotFound });
				else
					if (this.count[C_FoundRef]) this.filter({ _state: C_FoundRef });
					else
						this.filter()
		this.log();
	}

	// функция отрисовки страницы с данными
	this.updatePage = function () {
		var i, j, st = '', _, N = 0;
		var a = osm.filter_data;
		if (!a) return;
		osm.category = {};

		this.log('Генерация таблицы...');

		st += '<tr>';
		st += '<th colspan="2"></th>';
		for (field in validators[this.activeValidator].fields) {
			j = validators[this.activeValidator].fields[field];
			st += '<th title="' + j + '">';
			j = j
				.replace('ref:temples.ru', '<span title="ref:temples.ru - иднетификатор на temples.ru">temples.ru</span>')
				.replace('start_date', 'Дата постр.')
				.replace('disused', '<span title="disused - не работает?">Закр.</span>')
				.replace('denomination:ru', '<span title="denomination:ru - конфессия русск.">Конф.</span>')
				.replace('denomination', '<span title="denomination - конфессия">Конф.</span>')
				.replace('russian_orthodox', '<span title="russian_orthodox - признают Патриарха?">ПП</span>')
				.replace('contact:phone', 'Телефон')
				.replace('contact:website', 'Сайт')
				.replace('contact:facebook', 'facebook')
				.replace('contact:vk', 'vk')
				.replace('phone', 'Телефон')
				.replace('website', 'Сайт')
				.replace('building', 'Здание')
				.replace('alt_name', '<span title="alt_name - альтернативное название">Альт.</span>')
				.replace('old_name', '<span title="old_name - прежнее название">Прежн.</span>')
				.replace('official_name', '<span title="official_name - официальное название">Оф. назв.</span>')
				.replace('name:ru', '<span title="name:ru - название по русски">Русское назв.</span>')
				.replace('name:en', '<span title="name:en - название по английски">Англ. назв.</span>')
				.replace('name', 'Название')
				.replace('internet_access', '<span title="internet_access - доступ в интернет">www</span>')
				.replace('addr:postcode', 'Индекс')
				.replace('abandoned:place', '<span title="abandoned:plac - заброшенные или отсутствующие населённые пункты">a:place</span>')
				.replace('community:gender', 'Пол')
				.replace('official_status', 'Статус')
				.replace('addr:country', 'Страна')
				.replace('population:date', '<span title="population:date - год переписи">Год</span>')
				.replace('population', '<span title="population - население">Нас.</span>')
				.replace('_addr', 'Адрес')
				.replace('opening_hours', 'График работы')
				.replace('operator', 'Оператор')
				.replace('brand', 'Бренд')
				.replace('shop', 'Магазин')
				.replace('car_wash', 'Мойка')
				.replace('cafe', 'Кафе')
				.replace('toilets', 'Туалет')
				.replace('compressed_air', 'Подкачка')
				.replace('fuel:octane_100', '100')
				.replace('fuel:octane_98', '98')
				.replace('fuel:octane_95', '95')
				.replace('fuel:octane_92', '92')
				.replace('fuel:octane_80', '80')
				.replace('fuel:diesel', 'ДТ')
				.replace('fuel:lpg', 'ГАЗ')
				.replace('fuel:cng', 'КПГ')
				.replace('fuel:adblue', 'AdBlue')
				.replace('fuel:discount', 'Скидки')
				.replace('cash_in', 'Приём наличности')
				.replace('wheelchair', '<span title="wheelchair - доступность для людей на инвалидных колясках">Инв. коляски</span>')
				// Валюты
				.replace('currency:RUB', '<span title="currency:RUB - рубль">₽</span>')
				.replace('currency:USD', '<span title="currency:USD - доллар">$</span>')
				.replace('currency:EUR', '<span title="currency:EUR - евро">€</span>');
			st += j + '</th>';
		}
		st += '</tr>';

		var yasearch = '';

		for (i = osm._filter.page < 0 ? 0 : osm._filter.page * osm.numPerPage; i < a.length; i++) {
			if (!osm.category[a[i]._cat]) osm.category[a[i]._cat] = 0;
			osm.category[a[i]._cat]++;

			yasearch = this.activeValidator == 'wiki_places'
				? a[i]['addr:district'] + ', ' + (a[i]['official_status'] || '').replace('ru:', '') + ' ' + a[i]['name:ru']
				: a[i]._addr;

			osm_data = osm.search(a[i]);
			if (osm_data) a[i].id = osm_data.id;
			st += '<tr' + (osm_data && osm_data._used > 1 ?
				' class="multi" title="Объект привязан несколько раз, необходимо его расчленить!' + osm_data._used_name + '"' : '') + '>'
				+ '<td class="c">' + (osm_data
					? (osm_data && osm_data._used > 1 ? ' ' + osm.link(a[i]) : '') + osm.link(osm_data.id)
					: osm.link(a[i])) +
				' ' + osm.link_ya(a[i].lat, a[i].lon) +
				' ' + osm.link_yasearch(yasearch) +
				' ' + osm.link_eatlas(a[i].lat, a[i].lon) +
				'</td>'
				+ '<td class="c">' + (osm_data
					? osm.link_open_josm(osm_data.id) + ' ' +
					(osm_data._used > 1 ? '' : osm.link_export_update(a[i], osm_data))
					: osm.link_find_josm(a[i]) + ' ' + osm.link_export_create(a[i])) + '</td>'
				+ osm.compare(osm_data ? osm_data : {}, a[i], validators[this.activeValidator].fields)
				+ '</tr>';


			if (++N >= osm.numPerPage && osm._filter.page >= 0) break;
		}
		if (st) st = '<table>' + st + '</table>';
		$('validate', st);

		// быстрая выборка по населенным пунктам
		var t = '', c = 1; st = '';
		for (i in osm._cityList) {
			t = osm._cityList[i].name.replace(/"/g, '&quote;');
			c = osm._cityList[i].count + '';
			st += '<option value="' + t + '">' +
				t + ' '.repeat(25 - t.length - c.length) + c + '</option>';
		}
		if (st) st = '<select onchange="osm.searchByName($(\'search\').value = this.value)">' +
			'<option value="">Населённый пункт</option>' + st + '</select>';
		$('city', st);

		// номера страниц
		st = '';
		var _ = function (x) {
			return '<a href="#" class="' + (eval(x) == osm._filter._state ? 'active' : '') +
				'" onclick="osm._cityList = null; return osm.filter({_state:' + x + '})" ';
		}
		var R = function (f, code) {
			return '<a href="#" class="' + (eval(code) == osm._filter[f] ? 'active' : '') +
				'" onclick="osm._cityList = null; return osm.filter({' + f + ':' + code + '})" ';
		}
		if (this.count)
			st += 'Состояние: ' +
				'   ' + _('C_Equal') + 'title="Без ошибок">' + this.count[C_Equal] + '</a>' +
				' + ' + _('C_Diff') + 'title="Ошибка">' + this.count[C_Diff] + '</a>' +
				' + ' + _('C_Empty') + 'title="Неполные данные">' + this.count[C_Empty] + '</a>' +
				' + ' + _('C_NotFound') + 'title="Не найдено в OSM">' + this.count[C_NotFound] + '</a>' +
				' + ' + _('C_NoCoords') + 'title="Ошибка геокодинга">' + this.count[C_NoCoords] + '</a>' +
				' = ' + _('').replace(/ret.+"/, 'delete osm._filter._state;' +
					'return osm.filter()"') + 'title="Все объекты">' + this.count[C_Total] + '</a>' +
				' | ' + R('_ref', 'C_FoundRef') + 'title="Найдено по ref">' + this.count[C_FoundRef] + '</a>' +
				' | ' + R('_double', 'C_Double') + 'title="Дубликаты">' + this.count[C_Double] + '</a>' +
				' | ' + R('_used', 0) + 'title="&quot;Лишние&quot; объекты в OSM">' + this.count[C_Excess] + '</a>';
		$('state', st);

		st = 'Отфильтровано: ' + a.length + ' <a href="#" title="Нам нужно больше параметров!" class="simple" onclick="return osm.fastFilterToggle()">еще...</a>' + '<br>' + osm.drawFastFilter() + '<br>';
		var numPages = Math.ceil(a.length / osm.numPerPage);
		var big = numPages > 25 ? 1 : 0, skip = 0;
		var st_nav = '';
		if (osm._filter.page < 0)
			st_nav = '<br><a href="#all" onclick="return osm.page(0)">по страницам</a>';
		else
			if (numPages > 1) {
				st_nav += '<br>';
				for (i = 0; i < numPages; i++) {
					if (big)
						if (i > 10 && i < numPages - 5)
							if (mod(i - osm._filter.page) > 2) { skip = 1; continue; }
					if (skip) { st += ' ... '; skip = 0; }
					st_nav += '<a href="#"' + (osm._filter.page == i ? 'class="active"' : '') +
						'onclick="return osm.page(' + i + ')">' + (i + 1) + '</a> ';
				}
				st_nav += '<a href="#all" onclick="return osm.page(-1)">все</a>'
			}
		st += st_nav;
		$('pages', st);
		$('pages_bottom', numPages > 1 ? st_nav : '');
		this.log();
	}

	// отрисовка быстрого фильтра
	this.drawFastFilter = function () {
		var i, j, st = '', a;
		if (this._fast_filter_enable)
			for (i in this._fast_filter) {
				st += '<li>' + i + ':<br>';
				a = asort(this._fast_filter[i]);
				for (j in a)
					st += '<a href="#" onclick="return osm.fastFilter(this)">' + j + ' (' + a[j] + ')</a>';
				st += '</li>';
			}
		if (!st) return '';
		return '<br>'
			+ '<label><input type="checkbox" ' + (this._fast_filter_search_osm ? 'checked' : '')
			+ ' name="tsearch" onchange="osm.fastFilterOSMToggle(this.checked)">поиск по OSM объектам</label>'
			+ '<ul>' + st + '</ul>';
	}

	// выключатель быстрого фильтра
	this.fastFilterToggle = function () {
		this._fast_filter_enable ^= 1;
		this.filter();
		return false;
	}

	// выключатель поиска по OSM
	this.fastFilterOSMToggle = function (x) {
		this._fast_filter_search_osm = x;
		this.revalidate();
		return false;
	}

	// быстрая фильтрация
	this.fastFilter = function (x) {
		var value = x.innerHTML.replace(/\s*\(.+/, '');
		$('search').value = value;
		osm.searchByName(value);
		return false;
	}

	// смена страницы
	this.page = function (x) {
		this._filter.page = x;
		this.filter(this._filter, 1);
		return false;
	}

	// фильтрация записей
	this.filter = function (x, skipFilter) {
		var i, j;
		if (!x) x = {};
		if (this._filter[i = 'ref'] && x[i] == undefined) x[i] = this._filter[i];
		if (this._filter[i = '_addr'] && x[i] == undefined) x[i] = this._filter[i];
		this._filter = x;
		if (!this._filter.page) this._filter.page = 0;
		if (skipFilter) { this.updatePage(); return false; }

		// фильтруем записи
		this.filter_data = []; var self = this;

		var _ = function (a) {
			var skip = 0, j = 0, f;
			// перебираем поля фильтра по каждой записи
			for (j in self._filter)
				if (j != 'page') {
					if (j == '_used' && a._used) { skip = 1; break; } // объект использовался, а мы выводим непривязанные
					if (typeof (self._filter[j]) == 'string')
						f = self._filter[j].toLowerCase();
					if (j == '_addr' && self.activeValidator == 'wiki_places') {
						skip = 1;
						if (a[j = 'name:ru'] && a[j].toLowerCase().indexOf(f) != -1) skip = 0;
						if (a[j = 'place'] && a[j].toLowerCase().indexOf(f) != -1) skip = 0;
						if (a[j = 'official_status'] && a[j].toLowerCase().indexOf(f) != -1) skip = 0;
						if (a[j = 'addr:district'] && a[j].toLowerCase().indexOf(f) != -1) skip = 0;
					}
					else
						if (j != '_used')
							if (a[j] == undefined) { skip = 1; continue; }
							else {
								if (typeof (self._filter[j]) == 'string')
									if (a[j].toLowerCase().indexOf(f) == -1)
									{ skip = 1; break; }
								if (typeof (self._filter[j]) == 'number')
									if (a[j] != self._filter[j])
									{ skip = 1; break; }
							}
				}
			if (j && skip) return;
			// если дошли до сюда - добавляем запись в выборку
			self.filter_data.push(a);
		};

		if (this._filter._used != undefined)
			for (i in this.osm_data)
				for (j in this.osm_data[i])
					_(this.osm_data[i][j]);
		else
			for (i in this.real_data)
				_(this.real_data[i]);

		this.updateCityList();
		this.updatePage();

		return false;
	}

	// обновление списка городов отфильтрованных записей
	this.updateCityList = function () {
		var city, list = {};
		if (osm._cityList) return;
		for (i in osm.filter_data) {
			city = /(г\.|п\.|с\.|д\.|п\/о|пос\.|дер\.|р\.п\.+)\s*([А-Я].+?)(,|$)/.exec(osm.filter_data[i]._addr);
			city = city ? city[2] : '';
			city = city.replace(/ ул.+/, '');
			city = city.replace(/[\(\)].*/, '');
			if (city)
				if (!list[city]) list[city] = 1;
				else list[city]++;
		}
		osm._cityList = [];
		for (i in list) osm._cityList.push({ name: i, count: list[i] });
		osm._cityList.sort(function (x, y) {
			var N = 2;
			if (x.count > N && y.count <= N) return -1;
			if (y.count > N && x.count <= N) return 1;
			return x.name < y.name ? -1 : (x.name > y.name ? 1 : 0);
		});
	}

	// поиск по названию
	this.searchByName = function (x) {
		if (osm.timerSearch)
			clearInterval(osm.timerSearch);
		osm.timerSearch = setTimeout(function () {
			document.location = '#' + osm.activeRegion + '/' + osm.activeValidator + '/' + x;
			osm.filter({ _addr: x });
		}, 1000);
	}

	// поиск по номеру
	this.searchByRef = function (x) {
		if (osm.timerSearchRef)
			clearInterval(osm.timerSearchRef);
		osm.timerSearchRef = setTimeout(function () {
			//document.location = '#'+osm.activeRegion+'/'+osm.activeValidator+'/'+x;
			osm.filter({ ref: x });
		}, 1000);
	}

	// Поиск OSM объекта
	this.search = function (a, saveId) { // a - реальный объект для поиска
		var i, ref, hash, data, delta = 0.005, id = -1;
		if (this.activeValidator == 'wiki_places') delta = 0.02;
		this.delta = delta;

		// Поиск по ref
		if (a.ref) {
			if (i = this.osm_data_by_ref[a.ref]) {
				data = this.osm_data[i.hash];
				id = i.id;
			}
		}

		// Поиск по координатам
		if (id < 0 && a.lat) {
			hash = this.hash(a.lat, a.lon);
			data = this.osm_data[hash];
			if (!data) return null;

			var minDistance = 0;

			// пробуем найти в окрестности точки
			for (i = 0; i < data.length; i++) {
				if (1
					&& mod(a.lat - data[i].lat) < delta / 2
					&& mod(a.lon - data[i].lon) < delta
				) {
					if (0 // совпадение по ref
						|| (a[ref = 'ref'] && a[ref] == data[i][ref])
						|| (a[ref = 'ref:temples.ru'] && a[ref] == data[i][ref])
						|| (a[ref = 'okato:user'] && a[ref] == data[i][ref])
					) {
						id = i;
						break;
					}

					// или ищем минимальное удаление от адреса
					d = this.calcDistance(a, data[i]);
					if (id < 0 || d < minDistance) {
						id = i;
						minDistance = d;
					}
				}
			}
		}

		if (saveId && id >= 0) { // если объект привязан
			data[id]._used = (data[id]._used || 0) + 1;
			if (!data[id]._used_name) data[id]._used_name = '';
			data[id]._used_name += '\n' + (a['name:ru'] || a['name']) +
				' (ref=' + (a.ref) + ', lat=' + (Math.round(a.lat * 1000) / 1000) + ', lon=' + (Math.round(a.lon * 1000) / 1000) + ');';
		}

		return id < 0 ? null : data[id];
	}

	// расстояние между объектами
	this.calcDistance = function (x, y) {
		return mod(x.lat - y.lat) * mod(x.lat - y.lat) + mod(x.lon - y.lon) * mod(x.lon - y.lon);
	}

	// ссылка на сайт OSM
	this.link = function (id) {
		if (!id) return '';

		var d = this.delta;
		if (typeof (id) == 'object')
			if (!id.lat) return '';
			else
				return '<a href="https://www.openstreetmap.org/?box=yes&' +
					'bbox=' + encodeURIComponent([id.lon - d, id.lat - 0 + d / 2, id.lon - 0 + d, id.lat - d / 2]) +
					'" target="_blank" title="открыть в openstreetmap.org">' +
					'<img valign="absmiddle" width="16" src="https://www.openstreetmap.org/favicon.ico"/>' +
					'</a>';

		var pic = '';
		if (id.charAt(0) == 'n') pic = '2/20/Mf_node';
		if (id.charAt(0) == 'w') pic = '0/0f/Mf_area';
		if (id.charAt(0) == 'r') pic = 'd/d9/Mf_Relation';

		var url = 'https://www.openstreetmap.org/browse/' + id
			.replace('n', 'node/').replace('w', 'way/').replace('r', 'relation/');

		id = id.replace(/\D/g, '');

		return '<a href="' + url + '" target="_blank" title="открыть в openstreetmap.org">' +
			'<img valign="absmiddle" width="16" src="https://wiki.openstreetmap.org/w/images/' + pic + '.svg"/>' +
			'</a>';
	}

	// ссылка на "добавление объекта"
	this.link_export_create = function (a) {
		if (!a.lat) {
			return '';
		}

		var i, tags = '';

		for (i in a) {
			if ((i.charAt(0) != '_') && (i != 'lon') && (i != 'lat')) {
				tags += (tags ? '|' : '') + i + '=' + a[i];
			}
		}

		tags = tags.replace(/"/g, '&quot;').replace(/'/g, "\\'");
		return '<a href="#create" onclick="return osm.export_create(' + a.lon + ', ' + a.lat + ', \'' + tags + '\')" title="Добавить объект в JOSM" class="btn">ADD</a>';
	}

	//
	this.export_create = function (lon, lat, tags) {
		tags = encodeURIComponent(tags);
		axios.get('http://localhost:8111/add_node?lon=' + lon + '&lat=' + lat + '&addtags=' + tags)
			.catch(function (error) {
				if (error.response) {
					$('josm', error.response.data);
					style('josm', 'display: table; color: #D33;');
				}
			});
		return false;
	}

	// координаты в формате top/bottom/left/right
	this.coords = function (a, d) {
		if (!d) d = 0.00001;
		a.lat = parseFloat(a.lat);
		a.lon = parseFloat(a.lon);
		return ''
			+ '&top=' + (a.lat + d / 2)
			+ '&bottom=' + (a.lat - d / 2)
			+ '&right=' + (a.lon + d)
			+ '&left=' + (a.lon - d);
	}

	// ссылка на "обновление объекта"
	this.link_export_update = function (a, b) { // a - real, b - osm
		if (!a.id) {
			return '';
		}

		var i, tags = '';

		var f = validators[this.activeValidator].fields, k, v;

		for (i in f) {
			if (f[i].charAt(0) != '_') {
				if (this.compareField(b, a, f[i]) != C_Equal) {
					k = f[i]; v = a[k];
					if (!v) continue;

					// не устанавливаем устаревшие теги
					if (k == 'phone') a[k = 'contact:phone'] = v;
					if (k == 'website') a[k = 'contact:website'] = v;

					// новые ссылки на wikipedia и wikidata
					if (k == 'wikipedia')          a[k = 'brand:wikipedia'] = v;
					if (k == 'wikidata')           a[k = 'brand:wikidata'] = v;
					if (k == 'operator:wikipedia') a[k = 'brand:wikipedia'] = v;
					if (k == 'operator:wikidata')  a[k = 'brand:wikidata'] = v;

					// пропускаем неправильный ОКАТО
					if (k == 'okato:user' && v == '46') continue;

					tags += (tags ? '|' : '') + k + '=' + v;
				}
			}
		}

		if (!tags) {
			return '';
		}

		// заодно стираем устаревшие теги, если в OSM есть замена
		if (this.josmCanDeleteTags) {
			i = 'phone'; if (b[i] && a['contact:' + i]) tags += '|' + i + '=';
			i = 'website'; if (b[i] && a['contact:' + i]) tags += '|' + i + '=';
			i = 'population:year'; if (b[i] && a['population:date']) tags += '|' + i + '=';
			i = 'wikipedia'; if (b[i] && a['operator:' + i]) tags += '|' + i + '=';
			i = 'wikidata'; if (b[i] && a['operator:' + i]) tags += '|' + i + '=';
		}

		var d;

		if (a.id.charAt(0) != 'n') {
			d = 0.001; // FIXME: лучше передавать координату одного из угла, чтобы загружался только один объект!
		}

		tags = tags.replace(/"/g, '&quot;').replace(/'/g, "\\'");
		return '<a href="#export" onclick="return osm.export_update(\'' + a.id + '\', \'' + tags + '\')" title="Обновить объект в JOSM" class="btn">UPD</a>';
	}

	//
	this.export_update = function (id, tags) {
		osm.loaded_objects[id] = 1;
		tags = encodeURIComponent(tags);
		axios.get('http://localhost:8111/load_object?objects=' + id + '&addtags=' + tags);
		return false;
	}

	// ссылка "открыть в JOSM"
	this.link_open_josm = function (id) {
		return '<a href="#load" onclick="return osm.open_josm(\'' + id + '\')" title="Открыть объект в JOSM" class="btn">LOAD</a>';
	}

	//
	this.open_josm = function (id) {
		osm.loaded_objects[id] = 1;
		axios.get('http://localhost:8111/load_object?objects=' + id);
		return false;
	}

	// ссылка "координаты в JOSM"
	this.link_find_josm = function (a) {
		if (!a.lat) {
			return '';
		}
		return '<a href="#bbox" onclick="return osm.find_josm(\'' + osm.coords(a, 0.001) + '\')" title="Найти координаты в JOSM" class="btn">FIND</a>';
	}

	//
	this.find_josm = function (coords) {
		osm.loaded_objects[''] = 1;

		changeset_comment = '#validator.agily.ru ' + this.activeRegion + ':' + this.activeValidator;
		changeset_comment = encodeURIComponent(changeset_comment);

		axios.get('http://localhost:8111/load_and_zoom?' + coords + '&changeset_comment=' + changeset_comment);
		return false;
	}

	// Поиск по адресу в Яндекс.Картах
	this.link_yasearch = function (st) {
		return '<a href="/OSMvsNarod.html#q=' + st + '" target="_blank" title="Сравнение с Яндекс.Картами">' +
		       '<img valign="absmiddle" width="16" src="https://maps.yandex.ru/favicon.ico"/></a>';
	}

	//
	this.link_eatlas = function (lat, lon) {
		//пока не нашел как показать страницу...
		//return '<a href="http://atlas.mos.ru/?x=' + lon + '&y=' + lat + '&z=9&lang=ru" target="_blank" title="eAtlas">' +
		//	'eAtlas</a>';
		return '';
	}

	//
	this.link_ya = function (lat, lon) {
		return '<a href="https://maps.yandex.ru/?ll=' + lon + '%2C' + lat + '&z=18" target="_blank" title="открыть в Яндекс.Карте">' +
		       '<img valign="absmiddle" width="16" src="https://maps.yandex.ru/favicon.ico"></a>';
	}

	// сравнение одного поля в объектах
	this.compareField = function (osm, real, field) {
		if (!osm) osm = {};
		var a = osm[field] || '', b = real[field];
		if (b === '' || b == undefined || field.charAt(0) == '_') return C_Skip;
		if (a === b) return C_Equal;

		a = ('' + a).replace(/ё/g, 'е');
		b = ('' + b).replace(/ё/g, 'е');

		if (field == 'name') {
			// хак для почты: Отделение связи №XX
			var _ = function (x) {
				var _ = function (x, n) { return x.substr(-n).replace(/^0+/, ''); }
				x = x.replace(/(Почтовое отделение|Почта|Отделение почтовой связи)/, 'Отделение связи');
				x = x.replace(new RegExp('№' + real.ref), '!'); // совпадение по полному индексу
				x = x.replace(new RegExp('№' + _(real.ref, 3)), '!'); // посление три цифры
				x = x.replace(new RegExp('№' + _(real.ref, 2)), '!'); // посление две цифры
				x = x.replace(new RegExp('№' + _(real.ref, 1)), '!'); // последняя цифра
				return x;
			}
			if (real.ref && real.ref.length == 6) {
				a = _(a); b = _(b);
				// если отделение имеет название - считаем это правильным
				if (/Отделение связи "[^"]+"/.exec(a)) a = b;
				// если в названии нет цифр - то тоже пропускаем
				if (osm.name && !/\d/.exec(osm.name) && osm.name.toLowerCase() != 'почта') a = b;
			}
		}

		// игнорируем выходные дни в opening_hours
		if (field == 'opening_hours') {
			a = a.replace(/;[ a-z,-]+ off/i, '');
			b = b.replace(/;[ a-z,-]+ off/i, '');
		}

		// ищем телефонный номер в разных полях
		if (field == 'phone' && !a) a = osm['contact:phone'] || '';
		if (field == 'contact:phone' && !a) a = osm['phone'] || '';

		// ищем website в разных полях
		if (field == 'website' && !a) a = osm['contact:website'] || '';
		if (field == 'contact:website' && !a) a = osm['website'] || '';

		if (field == 'contact:phone' || field == 'phone') {
			// игнорируем дефисы в телефонах
			a = a.replace(/-/g, ' ')
			b = b.replace(/-/g, ' ')
		}

		if (field == 'website' || field == 'contact:website') {
			// игнорируем слеш на конце после имени домена
			a = a.replace(/(\.[a-z]{2,3})\/$/, '$1')
			b = b.replace(/(\.[a-z]{2,3})\/$/, '$1')
			// хак для сбера
			a = a.replace('/sberbank.', '/sbrf.');
			b = b.replace('/sberbank.', '/sbrf.');
			// игнорируем www
			a = a.replace(/www\./, '');
			b = b.replace(/www\./, '');
		}

		if (field == 'operator') {
			a = a.replace(/.*?"(.+?)".*/, '$1');
			b = b.replace(/.*?"(.+?)".*/, '$1');
		}

		// не считаем ошибкой небольшое изменение населения
		if (field == 'population') {
			if (Math.abs(a - b) < 100 || Math.abs(a - b) < a * 0.1)
				return C_Similar;
		}

		// не считаем ошибкой незаданную дату переписи населения
		if (field == 'population:date')
			if (a === '' && b)
				return C_Similar;

		// считаем пгт и рабочий посёлок равнозначными
		if (field == 'official_status') {
			a = a.replace('ru:рабочий поселок', 'ru:поселок городского типа');
			b = b.replace('ru:рабочий поселок', 'ru:поселок городского типа');
		}

		// перечисление строк через запятую и точку с запятой равнозначно
		a = a.replace(/[,;]\s+/g, ';');
		b = b.replace(/[,;]\s+/g, ';');

		if (!a) return C_Empty;
		return (a != b) ? C_Diff : C_Similar;
	}

	// сравнение объектов и генерация ячеек
	this.compare = function (osm, real, fields) {
		var i, st = '', v, t, cl, td_cl, cmp_res;
		for (i in fields) {
			cl = t = td_cl = '';
			v = osm[fields[i]] || '?';
			switch (cmp_res = this.compareField(osm, real, fields[i])) {
				case C_Skip:
					{
						cl = '';
						t = 'Правильное значение не известно';
						break;
					}
				case C_Empty:
					{
						cl = 'unknow';
						t = 'Нужно установить: ' + real[fields[i]];
						break;
					}
				case C_Similar:
				case C_Diff:
					{
						cl = 'ok'; if (v == '?') v = '';
						if (cmp_res == C_Similar) td_cl += ' similar';
						t = 'Нужно изменить на: ' + real[fields[i]];
						// простая раскраска, данные из OSM
						if (!this.color || this.color == 'osm') {
							if (real[fields[i]] != v) cl = 'err';
						} else {
							// в таблице выводим реальные данные
							if (this.color == 'real') {
								t = 'В OSM значение: ' + v;
								if (real[fields[i]] != v) cl = 'err';
								v = real[fields[i]];
							} else {
								// отмечаем посимвольно где ошибка
								if (this.color == 'diff')
									v = (function (from, to) {
										var i, res = '', c, cl, L = to.length; if (from.length > L) L = from.length;
										for (i = 0; i < L; i++) {
											c = from.charAt(i); cl = '';
											if (!c) { c = to.charAt(i); cl = 'unknow'; }
											else if (c != to.charAt(i)) cl = 'err';
											if (cl) cl = ' class="' + cl + '"';
											res += '<span' + cl + '>' + c + '</span>';
										}
										return res;
									})(v, real[fields[i]]);
							}
						}
						break;
					}
				case C_Equal:
					{
						cl = 'ok';
						t = 'Верно: ' + real[fields[i]];
						break;
					}
			}
			if (v == '?') v = osm[fields[i]] || real[fields[i]]; // COMMENT: нужно для вывода _addr
			if (v === '' || v == undefined) v = '?';

			if (fields[i] == '_addr') {
				cl += ' addr' + (osm.lat ? '" rel="&lat=' + osm.lat + '&lon=' + osm.lon : '');
				if (real.lat && real.lat != '?')
					v = '<a href="/OSMvsNarod.html#lat=' + real.lat +
						'&lon=' + real.lon + '&zoom=17&marker=yes"' +
						'title="Посмотреть метку геокодера"' +
						'target="_blank">' + v + '</a>';
			}

			if (fields[i] == 'ref:temples.ru' && real[fields[i]])
				v = '<a href="http://www.temples.ru/card.php?ID=' + real[fields[i]] + '" target="_blank">' + v + '</a>';
			if (fields[i] == 'brand:wikipedia' && real[fields[i]]) {
				v = '<a href="https://ru.wikipedia.org/wiki/' + real[fields[i]] + '" target="_blank">' + v + '</a>';
			}

			if (cl) cl = 'class="' + cl + '"';
			if (t) t = 'title="' + t.replace(/"/g, '&quot;') + '"';

			if (fields[i] == '_addr' && real._ref == C_FoundRef)
				td_cl += 'foundByRef';

			if (td_cl) td_cl = ' class="' + td_cl + '"';

			st += '<td' + td_cl + '><span ' + cl + t + '>' + v + '</span></td>';
		}
		return st;
	}

	// перевалидация
	this.update = function () {
		var i, objects = [], is_new = 0;
		for (i in osm.loaded_objects)
			if (!i) is_new = 1;
			else objects.push(i);

		var N = objects.length;

		$('btn_revalidate').value = 'Ждите...';
		$('btn_revalidate').disabled = true;

		axios.get('/common/validate.php?region=' + osm.activeRegion + '&validator=' + osm.activeValidator)
			.then(function (response) {
				alert(response.data);

				$('btn_revalidate').value = 'Перевалидировать';
				$('btn_revalidate').disabled = false;

				osm.load_state(true);
				osm.validate(osm.activeRegion, osm.activeValidator)
			})
			.catch(function (error) {
				console.log(error);
			});

		osm.loaded_objects = {};
	}

	// проверка адресов
	this.addrCheck = function () {
		$$('.addr', function (x) {
			if (!x.getAttribute('rel')) return;
			var f = '_f' + Math.round(Math.random() * 100000000);
			window[f] = function (a) {
				var st = x.innerHTML;
				st = st.replace(/<i.+/, '');
				a = a.address;
				st += '<i style="color: #777"><br><br>г. ' + (a.city || a.town || '?') + ', ' + (a.road || '?') + ', д. ' + (a.house_number || '?') + '</i>';
				x.innerHTML = st;
			}
			var url = 'https://nominatim.openstreetmap.org/reverse?json_callback=' + f +
				'&format=json&accept-language=ru&email=mail@cupivan.ru';
			url += x.getAttribute('rel');
			ajax.loadJS(url);
		});
	}

	// смена раскраски таблицы
	this.color_scheme = function (name) {
		this.color = name;
		this.updatePage();
	}

	// лог работы
	this.log = function (x) {
		x = x ? '<div>' + x + '</div>' : '';
		$('log', x);
	}

	// проверка включен ли JOSM нужной версии
	this.checkJosm = function () {
		axios.get('http://localhost:8111/version')
			.then(function (response) {
				if (response.data.protocolversion.major >= 1 && response.data.protocolversion.minor >= 5) {
					osm.josmCanDeleteTags = true;
					style('josm', 'display: none');
				} else {
					$('josm', '<b>Требуется обновление JOSM! <a href="http://josm.ru/">Загрузить</a></b>');
					style('josm', 'display: table; color: #990;');
				}
			})
			.catch(function (error) {
				$('josm', '<b>JOSM не запущен!</b>');
				style('josm', 'display: table; color: #D33;');
			});

		// Проверка каждые 30 секунд
		setTimeout(osm.checkJosm, 30 * 1000);
	}
	return this;

}

/* */
function mod(x) {
	return x < 0 ? -x : x;
}

/* */
String.prototype.repeat = function (x) {
	var i = 0, s = '', st = this;
	while (i < x) { s += st; i++; }
	return s;
}

/* сортировка хэша */
function asort(a) {
	var i, tmp = [];
	for (i in a) {
		tmp.push([i, a[i]]);
	}
	tmp.sort(function (x, y) { x = x[0]; y = y[0]; if (x == y) return 0; return x > y ? 1 : -1; });
	a = {};
	for (i in tmp) {
		a[tmp[i][0]] = tmp[i][1];
	}
	return a;
}
