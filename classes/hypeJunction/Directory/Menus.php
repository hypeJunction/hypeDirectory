<?php

namespace hypeJunction\Directory;

class Menus {

	/**
     * @param mixed $selected
     * @param mixed $filter
     * @return mixed
     */
    public static function getTabs($selected = '', $filter = true) {
		$tabs = elgg_trigger_plugin_hook('members:config', 'tabs', null, []);
		foreach ($tabs as $name => $tab) {
			$priority = elgg_extract('priority', $tab, 1);
			$priority = elgg_get_plugin_setting("tab:$name", 'hypedirectory', $priority);
			if ($filter && !$priority) {
				unset($tabs[$name]);
				continue;
			}
			$tab['priority'] = (int) $priority;
			if (!isset($tab['name'])) {
				$tab['name'] = $name;
			}
			if (!isset($tab['selected']) && $selected) {
				$tab['selected'] = $tab['name'] == $selected;
			}
			$tabs[$name] = $tab;
		}

		uasort($tabs, function ($a, $b) {
			return $a['priority'] <=> $b['priority'];
		});

		return $tabs;
	}

	/**
     * @param Elgg\Hook $hook
     * @return mixed
     */
    public static function prepareTabs(\Elgg\Hook $hook) {
		$return = $hook->getValue();


		$return['all'] = [
			'title' => elgg_echo('members:title:all'),
			'url' => 'members/all',
		];

		foreach ($return as $key => $value) {
			if (!isset($value['name'])) {
				$value['name'] = $key;
			}
			if (isset($value['title'])) {
				$value['text'] = $value['title'];
			}
			if (isset($value['url'])) {
				$value['href'] = $value['url'];
			}
			$return[$key] = $value;
		}

		return $return;
	}

	/**
     * @param Elgg\Hook $hook
     * @return mixed
     */
    public static function setupSiteMenu(\Elgg\Hook $hook) {
		$return = $hook->getValue();


		$tabs = self::getTabs();
		if (empty($tabs)) {
			$return = $return->filter(function(\ElggMenuItem $item) {
				return $item->getName() !== 'members';
			});
		}

		return $return;
	}

}
