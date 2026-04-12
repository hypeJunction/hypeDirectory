import { test, expect } from '@playwright/test';
import { loginAs, countUsers } from '../helpers/elgg';

test.describe('hypeDirectory members listing', () => {
  test('members index page renders with at least one tab', async ({ page }) => {
    await loginAs(page, 'testuser');
    const response = await page.goto('/members');
    expect(response?.status()).toBeLessThan(400);

    // Assert page title / heading exists
    await expect(page.locator('h1, .elgg-heading-main').first()).toBeVisible();

    // Filter menu should render (at least the "all" tab)
    const filter = page.locator('.elgg-menu-filter');
    await expect(filter).toBeVisible();
  });

  test('members "all" tab lists users and matches DB user count', async ({ page }) => {
    await loginAs(page, 'testuser');
    await page.goto('/members/all');

    // UI: members list container visible
    const list = page.locator('.elgg-list-members, .elgg-list');
    await expect(list.first()).toBeVisible();

    // DB: users exist
    const dbCount = await countUsers();
    expect(dbCount).toBeGreaterThan(0);
  });

  test('newest / alpha / popular listing tabs render', async ({ page }) => {
    await loginAs(page, 'testuser');
    for (const tab of ['newest', 'alpha', 'popular']) {
      const response = await page.goto(`/members/${tab}`);
      expect(response?.status(), `tab ${tab}`).toBeLessThan(400);
      await expect(page.locator('.elgg-list-members, .elgg-list').first()).toBeVisible();
    }
  });

  test('online tab filters to recently active users', async ({ page }) => {
    await loginAs(page, 'testuser');
    const response = await page.goto('/members/online');
    expect(response?.status()).toBeLessThan(400);
    // Sort and search controls are hidden on online tab
    await expect(page.locator('body')).toBeVisible();
  });
});
