<?php

namespace hypeJunction\Directory;

/**
 * Lists class.
 */
class Lists {

	/**
	 * Prepares members list
	 *
	 * @param \Elgg\Event $event "members:list"
	 * @return mixed
	 */
	public static function render(\Elgg\Event $event) {
		if ($event->getValue()) {
			return;
		}

		if (elgg_view_exists("members/listing/$event->getType()")) {
			return elgg_view("members/listing/$event->getType()", $event->getParams());
		}
	}
}
