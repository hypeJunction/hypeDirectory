<?php

namespace hypeJunction\Directory;

use Elgg\IntegrationTestCase;

/**
 * Verifies that plugin hook registrations declared in elgg-plugin.php
 * are active when the plugin is enabled.
 */
class HookRegistrationIntegrationTest extends IntegrationTestCase {

    public function up() {}

    public function down() {}

    /**
     * @return void
     */
    public function testMembersConfigTabsHookRegistered(): void {
        $hooks = _elgg_services()->hooks;
        $registered = $hooks->hasHandler('members:config', 'tabs');
        $this->assertTrue($registered, 'hypeDirectory should register members:config/tabs hook');
    }

    /**
     * @return void
     */
    public function testMembersListAllHookRegistered(): void {
        $hooks = _elgg_services()->hooks;
        $this->assertTrue(
            $hooks->hasHandler('members:list', 'all'),
            'hypeDirectory should register members:list/all hook'
        );
    }

    /**
     * @return void
     */
    public function testSiteMenuRegisterHookRegistered(): void {
        $hooks = _elgg_services()->hooks;
        $this->assertTrue(
            $hooks->hasHandler('register', 'menu:site'),
            'hypeDirectory should register register/menu:site hook'
        );
    }
}
