<?php

namespace hypeJunction\Directory;

/**
 * Lists class.
 */
class Lists {

	/**
	 * Prepares members list
	 *
	 * @param \Elgg\Hook $hook "members:list"
	 * @return mixed
	 */
	public static function render(\Elgg\Hook $hook) {
		if ($hook->getValue()) {
			return;
		}

		if (elgg_view_exists("members/listing/$hook->getType()")) {
			return elgg_view("members/listing/$hook->getType()", $hook->getParams());
		}
	}
}
