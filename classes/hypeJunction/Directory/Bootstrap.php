<?php

namespace hypeJunction\Directory;

use Elgg\DefaultPluginBootstrap;

/**
 * Bootstrap class.
 */
class Bootstrap extends DefaultPluginBootstrap {

	/**
	 * {@inheritdoc}
	 */
	public function init(): void {
		elgg_register_event_handler('members:config', 'tabs', [Menus::class, 'prepareTabs'], 999);
		elgg_register_event_handler('members:list', 'all', [Lists::class, 'render']);

		// Clean up members plugin hook registrations so hypeDirectory's handler wins
		$list_types = ['newest', 'alpha', 'popular', 'online'];
		foreach ($list_types as $type) {
			elgg_unregister_event_handler('members:list', $type, "members_list_$type");
		}
	}
}
