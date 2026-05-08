<?php

namespace hypeJunction\Directory;

use Elgg\UnitTestCase;

/**
 * Unit tests for the Lists hook handler. Lists::render should early-return
 * (return null) when the hook value is already truthy, so other handlers
 * cannot be clobbered.
 */
class ListsUnitTest extends UnitTestCase {

    public function up() {}

    public function down() {}

    /**
     * @return void
     */
    public function testRenderReturnsNullWhenValuePresent(): void {
        $hook = $this->getMockBuilder(\Elgg\Event::class)->disableOriginalConstructor()->getMock();
        $hook->method('getValue')->willReturn('existing');
        $hook->method('getType')->willReturn('newest');

        $this->assertNull(Lists::render($hook));
    }
}
