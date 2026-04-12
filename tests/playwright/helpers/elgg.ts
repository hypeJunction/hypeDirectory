import { Page } from '@playwright/test';
import mysql from 'mysql2/promise';

const DB_CONFIG = {
  host: process.env.ELGG_DB_HOST || 'db',
  port: Number(process.env.ELGG_DB_PORT || 3306),
  user: process.env.ELGG_DB_USER || 'elgg',
  password: process.env.ELGG_DB_PASS || 'elgg',
  database: process.env.ELGG_DB_NAME || 'elgg',
};

export async function loginAs(page: Page, username: string, password: string = 'testpass123') {
  await page.goto('/login');
  await page.fill('input[name="username"]', username);
  await page.fill('input[name="password"]', password);
  await page.click('button[type="submit"]');
  await page.waitForLoadState('networkidle');
}

export async function queryDb(sql: string, params: any[] = []) {
  const conn = await mysql.createConnection(DB_CONFIG);
  try {
    const [rows] = await conn.execute(sql, params);
    return rows as any[];
  } finally {
    await conn.end();
  }
}

export async function countUsers(): Promise<number> {
  const rows = await queryDb(
    "SELECT COUNT(*) AS c FROM elgg_entities WHERE type = 'user'"
  );
  return Number(rows[0]?.c ?? 0);
}

export async function getPluginSetting(pluginId: string, name: string): Promise<string | null> {
  const rows = await queryDb(
    `SELECT ps.value
       FROM elgg_private_settings ps
       JOIN elgg_entities e ON e.guid = ps.entity_guid
      WHERE ps.name = ? AND e.type = 'object' AND e.subtype = 'plugin'
        AND ps.entity_guid = (
          SELECT guid FROM elgg_entities WHERE type = 'object' AND subtype = 'plugin' LIMIT 1
        )
      LIMIT 1`,
    [name]
  );
  return rows[0]?.value ?? null;
}
