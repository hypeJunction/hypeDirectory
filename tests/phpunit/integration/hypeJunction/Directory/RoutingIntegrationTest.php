<?php

namespace hypeJunction\Directory;

use Elgg\IntegrationTestCase;

/**
 * Verifies that the members resource views exist and can be located by
 * elgg_view_exists. The plugin itself does not register routes — it relies
 * on the `members` plugin for /members URL routing but supplies the
 * listing resource views consumed by that plugin.
 */
class RoutingIntegrationTest extends IntegrationTestCase {

    public function up() {}

    public function down() {}

    /**
     * @return void
     */
    public function testResourceViewsExist(): void {
        $this->assertTrue(elgg_view_exists('resources/members/index'));
        $this->assertTrue(elgg_view_exists('resources/members/search'));
    }

    /**
     * @return void
     */
    public function testListingViewsExist(): void {
        foreach (['all', 'alpha', 'newest', 'popular', 'online'] as $type) {
            $this->assertTrue(
                elgg_view_exists("members/listing/$type"),
                "members/listing/$type view should exist"
            );
        }
    }

    /**
     * @return void
     */
    public function testFilterAndSidebarViewsExist(): void {
        $this->assertTrue(elgg_view_exists('members/filter'));
        $this->assertTrue(elgg_view_exists('members/sidebar'));
    }

    /**
     * @return void
     */
    public function testPluginSettingsViewExists(): void {
        $this->assertTrue(elgg_view_exists('plugins/hypeDirectory/settings'));
    }
}
