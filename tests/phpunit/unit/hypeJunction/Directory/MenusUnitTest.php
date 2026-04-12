<?php

namespace hypeJunction\Directory;

use Elgg\UnitTestCase;

/**
 * Pure-logic tests for Menus that do not require DB.
 */
class MenusUnitTest extends UnitTestCase {

    public function up() {}

    public function down() {}

    public function testPrepareTabsInjectsAllTab(): void {
        $hook = $this->getMockBuilder(\Elgg\Hook::class)->getMock();
        $hook->method('getValue')->willReturn([]);

        $result = Menus::prepareTabs($hook);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('all', $result);
        $this->assertSame('members/all', $result['all']['href']);
        // prepareTabs copies title -> text
        $this->assertArrayHasKey('text', $result['all']);
    }

    public function testPrepareTabsNormalisesExistingEntries(): void {
        $hook = $this->getMockBuilder(\Elgg\Hook::class)->getMock();
        $hook->method('getValue')->willReturn([
            'newest' => [
                'title' => 'Newest',
                'url'   => 'members/newest',
            ],
        ]);

        $result = Menus::prepareTabs($hook);
        $this->assertSame('newest', $result['newest']['name']);
        $this->assertSame('Newest', $result['newest']['text']);
        $this->assertSame('members/newest', $result['newest']['href']);
        // 'all' always gets added
        $this->assertArrayHasKey('all', $result);
    }
}
