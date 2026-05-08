<?php

use hypeJunction\Directory\Bootstrap;
use hypeJunction\Directory\Lists;
use hypeJunction\Directory\Menus;

return [
	'plugin' => [
		'name' => 'hypeDirectory',
		'version' => '5.0.0',
		'dependencies' => [
			'members' => [],
			'hypelists' => [],
		],
	],
	'bootstrap' => Bootstrap::class,
	'events' => [
		'register' => [
			'menu:site' => [
				Menus::class . '::setupSiteMenu' => [],
			],
		],
	],
];
