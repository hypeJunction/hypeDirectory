# hypeDirectory — Architecture (Elgg 4.x)

Improved members directory pages for Elgg. Provides tab-driven listings, configurable sorting, and optional public-access gating for the `/members` route family.

## Plugin metadata

- **id:** `hypedirectory` (lowercase, matches dir name — Elgg 4.x requirement)
- **vendor:** `hypejunction/hypedirectory`
- **version:** 1.0.3
- **php:** >=7.4
- **elgg:** ^4.0
- **dependencies:** `members` (core), `hypelists` (hypejunction)

## Directory layout

```
hypedirectory/
├── composer.json           # vendor metadata, deps, autoload
├── elgg-plugin.php         # 4.x bootstrap declaration (replaces manifest.xml)
├── classes/
│   └── hypeJunction/Directory/
│       ├── Bootstrap.php   # plugin lifecycle (init/ready/upgrade/etc.)
│       ├── Router.php      # route registration (/members/*)
│       ├── Menus.php       # tab building + site menu integration
│       └── Lists.php       # list rendering hook handler
├── views/default/
│   ├── members/            # filter, sidebar, listing/{all,online,popular,…}.php
│   └── resources/members/  # /members route entry view
├── languages/              # translations
└── tests/
    ├── phpunit/{unit,integration}/
    └── playwright/
```

## Registered hooks (declarative, elgg-plugin.php)

| event             | type        | handler                                            | priority |
|-------------------|-------------|----------------------------------------------------|----------|
| `members:config`  | `tabs`      | `hypeJunction\Directory\Menus::prepareTabs`        | 999      |
| `members:list`    | `all`       | `hypeJunction\Directory\Lists::render`             | default  |
| `register`        | `menu:site` | `hypeJunction\Directory\Menus::setupSiteMenu`      | default  |

## Routes

- `/members` and `/members/{page}` — handled via `views/default/resources/members/index.php`. Tab list comes from `Menus::getTabs()`, which fans out via the `members:config / tabs` hook.

## Plugin settings

| key                       | default          | meaning                                       |
|---------------------------|------------------|-----------------------------------------------|
| `tab:<name>`              | `1`              | priority for tab `<name>`; `0` hides the tab |
| `default_sort`            | `alpha::asc`     | default sort order for the "all" listing     |
| `disable_public_access`   | (unset = public) | when truthy, gates the directory pages       |

## Migration notes (Elgg 3.x → 4.x)

- Branch: `migrate/elgg-4.x`.
- `manifest.xml` deleted; metadata moved to `composer.json` + `elgg-plugin.php` `'plugin'` key (4.x replacement).
- `start.php` removed; bootstrap moved to `hypeJunction\Directory\Bootstrap`.
- Hook handlers rewritten to single-arg `\Elgg\Hook` signature.
- **Bug fix during gate run:** all `elgg_get_plugin_setting(..., 'hypeDirectory', ...)` and `elgg_get_plugin_from_id('hypeDirectory')` callsites were changed to lowercase `'hypedirectory'`. The plugin id MUST match the lowercase directory name in 4.x; the camelCase string was silently returning `false`/`null` and dropping all tabs from `Menus::getTabs()`.
- `composer.json`: `composer/installers ~1.0` → `^2.0`; added `elgg/elgg ^4.0`, `hypejunction/hypelists`; added `extra.elgg-plugin.id = "hypedirectory"`; switched license to `GPL-2.0-or-later`.
- `members` core dependency declared via `elgg-plugin.php` `'plugin'.'dependencies'` (it ships in `vendor/elgg/elgg/mod/members`, not as a separate composer package).

## No data migration required

This plugin stores nothing in the entities/metadata tables. Plugin settings (`tab:*`, `default_sort`, `disable_public_access`) carry over unchanged because the keys are unchanged and Elgg keeps `private_settings` rows intact across plugin upgrades. **No `Elgg\Upgrade\Batch` script is required.**

## Test surface

- **PHPUnit:** 18 tests, 125 assertions
  - unit: `Menus`, `Lists` — pure-PHP behavior
  - integration: bootstrap/hook registration, tabs assembly, routing, view rendering
- **Playwright:** committed under `tests/playwright/` (not run as part of this gate; see fleet roadmap)
