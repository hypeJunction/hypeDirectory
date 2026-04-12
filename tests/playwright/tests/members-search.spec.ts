import { test, expect } from '@playwright/test';
import { loginAs } from '../helpers/elgg';

test.describe('hypeDirectory members search', () => {
  test('search form redirects with query param', async ({ page }) => {
    await loginAs(page, 'testuser');
    await page.goto('/members/all');

    const searchInput = page.locator('input[name="member_query"]').first();
    if (await searchInput.count() === 0) {
      test.skip(true, 'Search input not exposed on this tab');
    }

    await searchInput.fill('test');
    await searchInput.press('Enter');

    // resources/members/search redirects to /members?query=...
    await page.waitForURL(/members\?.*query=test/);
    await expect(page).toHaveURL(/query=test/);
  });
});
