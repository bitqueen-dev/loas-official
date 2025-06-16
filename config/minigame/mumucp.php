<?php
return [
	'setting' => [
		'period' => '2018-07-26 15:00:00|2018-09-18 23:59:59',
	],

	'givePointItems' => [
		'2401' => [ 'itemId' => 2401, 'name' => 'ムム様の運勢占い 超大吉', 'givePoint' => 100, 'probability' => 2, 'next' => 1, 'img' => 1,],
		'2402' => [ 'itemId' => 2402, 'name' => 'ムム様の運勢占い 大吉', 'givePoint' => 50, 'probability' => 5, 'next' => 2, 'img' => 2, ],
		'2403' => [ 'itemId' => 2403, 'name' => 'ムム様の運勢占い 中吉1', 'givePoint' => 20, 'probability' => 11, 'next' => 3, 'img' => 3, ],
		'2404' => [ 'itemId' => 2404, 'name' => 'ムム様の運勢占い 中吉2', 'givePoint' => 20, 'probability' => 12, 'next' => 3, 'img' => 4, ],
		'2405' => [ 'itemId' => 2405, 'name' => 'ムム様の運勢占い 吉1', 'givePoint' => 10, 'probability' => 15, 'next' => 4, 'img' => 5, ],
		'2406' => [ 'itemId' => 2406, 'name' => 'ムム様の運勢占い 吉2', 'givePoint' => 10, 'probability' => 15, 'next' => 4, 'img' => 6, ],
		'2407' => [ 'itemId' => 2407, 'name' => 'ムム様の運勢占い 末吉1', 'givePoint' => 5, 'probability' => 8, 'next' => 5, 'img' => 7, ],
		'2408' => [ 'itemId' => 2408, 'name' => 'ムム様の運勢占い 末吉2', 'givePoint' => 5, 'probability' => 7, 'next' => 5, 'img' => 8, ],
		'2409' => [ 'itemId' => 2409, 'name' => 'ムム様の運勢占い 凶1', 'givePoint' => 0, 'probability' => 8, 'next' => 6, 'img' => 9, ],
		'2410' => [ 'itemId' => 2410, 'name' => 'ムム様の運勢占い 凶2', 'givePoint' => 0, 'probability' => 7, 'next' => 6, 'img' => 10, ],
		'2411' => [ 'itemId' => 2411, 'name' => 'ムム様の運勢占い 大凶1', 'givePoint' => 0, 'probability' => 3, 'next' => 6, 'img' => 11, ],
		'2412' => [ 'itemId' => 2412, 'name' => 'ムム様の運勢占い 大凶2', 'givePoint' => 0, 'probability' => 2, 'next' => 6, 'img' => 12, ],
		'2413' => [ 'itemId' => 2413, 'name' => 'ムム様の運勢占い ???', 'givePoint' => 10, 'probability' => 5, 'next' => 0, 'img' => 13, ],
	],
	
	'nextInfo' => [
		1 => [ 
			'2401' => [ 'itemId' => '2401', 'probability' => 90, ], 
			'2413' => [ 'itemId' => '2413', 'probability' => 10, ],
		],
		2 => [
			'2401' => [ 'itemId' => '2401', 'probability' => 10, ], 
			'2402' => [ 'itemId' => '2402', 'probability' => 80, ], 
			'2413' => [ 'itemId' => '2413', 'probability' => 10, ],
		],
		3 => [
			'2401' => [ 'itemId' => '2401', 'probability' => 5, ], 
			'2402' => [ 'itemId' => '2402', 'probability' => 25, ], 
			'2403' => [ 'itemId' => '2403', 'probability' => 30, ], 
			'2404' => [ 'itemId' => '2404', 'probability' => 30, ], 
			'2413' => [ 'itemId' => '2413', 'probability' => 10, ],
		],
		4 => [
			'2402' => [ 'itemId' => '2402', 'probability' => 20, ], 
			'2403' => [ 'itemId' => '2403', 'probability' => 10, ], 
			'2404' => [ 'itemId' => '2404', 'probability' => 10, ], 
			'2405' => [ 'itemId' => '2405', 'probability' => 25, ], 
			'2406' => [ 'itemId' => '2406', 'probability' => 25, ], 
			'2413' => [ 'itemId' => '2413', 'probability' => 10, ],
		],
		5 => [
			'2402' => [ 'itemId' => '2402', 'probability' => 10, ], 
			'2403' => [ 'itemId' => '2403', 'probability' => 10, ], 
			'2404' => [ 'itemId' => '2404', 'probability' => 10, ], 
			'2405' => [ 'itemId' => '2405', 'probability' => 10, ], 
			'2406' => [ 'itemId' => '2406', 'probability' => 10, ], 
			'2407' => [ 'itemId' => '2407', 'probability' => 20, ], 
			'2408' => [ 'itemId' => '2408', 'probability' => 20, ], 
			'2413' => [ 'itemId' => '2413', 'probability' => 10, ],
		],
		6 => [
			'2402' => [ 'itemId' => '2402', 'probability' => 10, ], 
			'2403' => [ 'itemId' => '2403', 'probability' => 10, ], 
			'2404' => [ 'itemId' => '2404', 'probability' => 10, ], 
			'2405' => [ 'itemId' => '2405', 'probability' => 15, ], 
			'2406' => [ 'itemId' => '2406', 'probability' => 15, ], 
			'2407' => [ 'itemId' => '2407', 'probability' => 13, ], 
			'2408' => [ 'itemId' => '2408', 'probability' => 12, ], 
			'2409' => [ 'itemId' => '2409', 'probability' => 3, ], 
			'2410' => [ 'itemId' => '2410', 'probability' => 2, ], 
			'2413' => [ 'itemId' => '2413', 'probability' => 10, ],
		],
	],
];