import { test, expect } from '@playwright/test';
import { loginAs } from '../helpers/elgg';

test.describe('hypeDirectory admin settings', () => {
  test('settings page renders without errors', async ({ page }) => {
    await loginAs(page, 'admin');
    const response = await page.goto('/admin/plugin_settings/hypeDirectory');
    expect(response?.status()).toBeLessThan(400);

    // Settings form visible
    await expect(page.locator('form').first()).toBeVisible();

    // No error system messages
    await expect(page.locator('.elgg-system-messages .elgg-message-error')).toHaveCount(0);

    // Each known field is present
    await expect(page.locator('select[name="params[default_sort]"]')).toBeVisible();
    await expect(page.locator('select[name="params[disable_public_access]"]')).toBeVisible();
  });

  test('disable_public_access setting gates anonymous /members access', async ({ page, context }) => {
    await loginAs(page, 'admin');
    await page.goto('/admin/plugin_settings/hypeDirectory');

    // Enable the gatekeeper
    await page.selectOption('select[name="params[disable_public_access]"]', '1');
    await page.click('button[type="submit"]');
    await page.waitForLoadState('networkidle');

    // Anonymous context
    const anon = await context.browser()?.newContext();
    if (!anon) test.skip(true, 'No anonymous browser context available');
    const anonPage = await anon!.newPage();
    const response = await anonPage.goto('/members');
    // Expect a redirect to login or a 403
    expect([200, 302, 403]).toContain(response?.status() ?? 0);
    if (response?.status() === 200) {
      await expect(anonPage).toHaveURL(/login/);
    }
    await anon!.close();

    // Revert setting
    await page.goto('/admin/plugin_settings/hypeDirectory');
    await page.selectOption('select[name="params[disable_public_access]"]', '0');
    await page.click('button[type="submit"]');
  });
});
