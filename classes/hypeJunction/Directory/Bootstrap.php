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
	public function init() {
		// Clean up members plugin hook registration
		$list_types = ['newest', 'alpha', 'popular', 'online'];
		foreach ($list_types as $type) {
			elgg_unregister_event_handler('members:list', $type, "members_list_$type");
		}
	}
}
