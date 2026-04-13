<?php

namespace hypeJunction\Directory;

use Elgg\IntegrationTestCase;

/**
 * Smoke tests that render key plugin views with minimal parameters to
 * catch parse errors, undefined function calls, and other migration
 * regressions. A view that throws is an immediate red flag.
 */
class ViewRenderIntegrationTest extends IntegrationTestCase {

    public function up() {}

    public function down() {}

    /**
     * @return void
     */
    public function testFilterViewRendersWithoutError(): void {
        $output = elgg_view('members/filter', ['filter_context' => 'all']);
        $this->assertIsString($output);
    }

    /**
     * @return void
     */
    public function testSidebarViewRendersWithoutError(): void {
        $output = elgg_view('members/sidebar', ['filter_context' => 'all']);
        $this->assertIsString($output);
    }

    /**
     * @return void
     */
    public function testListingAllViewRendersWithoutError(): void {
        $output = elgg_view('members/listing/all', [
            'options' => [
                'type' => 'user',
                'limit' => 1,
            ],
        ]);
        $this->assertIsString($output);
    }

    /**
     * @return void
     */
    public function testListingOnlineViewRendersWithoutError(): void {
        $output = elgg_view('members/listing/online', [
            'options' => [
                'type' => 'user',
                'limit' => 1,
            ],
        ]);
        $this->assertIsString($output);
    }
}
