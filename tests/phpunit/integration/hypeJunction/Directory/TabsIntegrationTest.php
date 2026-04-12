<?php

namespace hypeJunction\Directory;

use Elgg\IntegrationTestCase;

/**
 * End-to-end tests for tab building — exercises plugin settings +
 * hook cascade to assemble the directory's navigation tabs.
 */
class TabsIntegrationTest extends IntegrationTestCase {

    public function up() {}

    public function down() {}

    public function testGetTabsReturnsAtLeastAllTab(): void {
        $tabs = Menus::getTabs();
        $this->assertIsArray($tabs);
        $this->assertArrayHasKey('all', $tabs, 'Directory should always expose the "all" tab');
        $this->assertSame('members/all', $tabs['all']['href'] ?? $tabs['all']['url'] ?? null);
    }

    public function testPluginSettingsCanHideTab(): void {
        $plugin = elgg_get_plugin_from_id('hypeDirectory');
        if (!$plugin) {
            $this->markTestSkipped('hypeDirectory plugin not installed in test DB');
        }

        $previous = $plugin->getSetting('tab:all');
        $plugin->setSetting('tab:all', 0);

        try {
            $tabs = Menus::getTabs();
            $this->assertArrayNotHasKey('all', $tabs, 'Setting tab:all=0 should hide the "all" tab');
        } finally {
            if ($previous === null) {
                $plugin->unsetSetting('tab:all');
            } else {
                $plugin->setSetting('tab:all', $previous);
            }
        }
    }

    public function testDefaultSortSettingAvailable(): void {
        $plugin = elgg_get_plugin_from_id('hypeDirectory');
        if (!$plugin) {
            $this->markTestSkipped('hypeDirectory plugin not installed in test DB');
        }

        $previous = $plugin->getSetting('default_sort');
        $plugin->setSetting('default_sort', 'time_created::desc');

        try {
            $this->assertSame(
                'time_created::desc',
                $plugin->getSetting('default_sort')
            );
        } finally {
            if ($previous === null) {
                $plugin->unsetSetting('default_sort');
            } else {
                $plugin->setSetting('default_sort', $previous);
            }
        }
    }
}
