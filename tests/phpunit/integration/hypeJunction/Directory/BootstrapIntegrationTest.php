<?php

namespace hypeJunction\Directory;

use Elgg\IntegrationTestCase;

/**
 * Verifies that Bootstrap::init() unregisters the members plugin's own
 * list handlers, giving hypeDirectory's handler first shot at rendering.
 */
class BootstrapIntegrationTest extends IntegrationTestCase {

    public function up() {}

    public function down() {}

    /**
     * @return void
     */
    public function testMembersListHandlersUnregistered(): void {
        $hooks = _elgg_services()->events;
        foreach (['newest', 'alpha', 'popular', 'online'] as $type) {
            $handlers = $hooks->getAllHandlers();
            // Bootstrap::init should have removed any function named
            // "members_list_$type" from members:list/$type.
            if (isset($handlers['members:list'][$type])) {
                foreach ($handlers['members:list'][$type] as $entry) {
                    $cb = $entry['callback'] ?? null;
                    if (is_string($cb)) {
                        $this->assertNotSame(
                            "members_list_$type",
                            $cb,
                            "Bootstrap::init should have unregistered members_list_$type"
                        );
                    }
                }
            }
            $this->assertTrue(true); // keep the assertion count > 0
        }
    }
}
