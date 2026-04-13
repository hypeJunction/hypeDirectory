<?php

use hypeJunction\Directory\Bootstrap;
use hypeJunction\Directory\Lists;
use hypeJunction\Directory\Menus;

return [
	'plugin' => [
		'name' => 'hypeDirectory',
		'version' => '1.0.3',
		'dependencies' => [
			'members' => [],
			'hypelists' => [],
		],
	],
	'bootstrap' => Bootstrap::class,
	'hooks' => [
		'members:config' => [
			'tabs' => [
				Menus::class . '::prepareTabs' => ['priority' => 999],
			],
		],
		'members:list' => [
			'all' => [
				Lists::class . '::render' => [],
			],
		],
		'register' => [
			'menu:site' => [
				Menus::class . '::setupSiteMenu' => [],
			],
		],
	],
];
