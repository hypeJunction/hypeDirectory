## Unreleased — Elgg 4.x migration (2026-04-13)

- Migrated to Elgg 4.x (3.x → 4.x). `manifest.xml` removed, metadata in `elgg-plugin.php` + `composer.json`.
- Plugin id is now lowercase `hypedirectory` (matches dir name; required by Elgg 4.x).
- Bug fix: `elgg_get_plugin_setting(...)` / `elgg_get_plugin_from_id(...)` callsites updated to use the lowercase id, fixing tab dropping and gating regressions.
- Hook handlers rewritten to single-arg `\Elgg\Hook` signature.
- composer: `composer/installers ^2.0`, added `elgg/elgg ^4.0` and `hypejunction/hypelists`.
- See `ARCHITECTURE.md` for full plugin shape.

<a name="1.0.3"></a>
## [1.0.3](https://github.com/hypeJunction/hypeDirectory/compare/1.0.2...v1.0.3) (2016-09-16)


### Bug Fixes

* **releases:** fix release info ([3add61c](https://github.com/hypeJunction/hypeDirectory/commit/3add61c))



<a name="1.0.2"></a>
## [1.0.2](https://github.com/hypeJunction/Elgg-hypeDirectory/compare/1.0.1...v1.0.2) (2016-09-16)


### Bug Fixes

* **lists:** apply classes to the member list ([949c82e](https://github.com/hypeJunction/Elgg-hypeDirectory/commit/949c82e))



<a name="1.0.1"></a>
## [1.0.1](https://github.com/hypeJunction/Elgg-hypeDirectory/compare/1.0.0...v1.0.1) (2016-09-16)


### Features

* **releases:** rename the plugin into hypeDirectory ([cd4ca8f](https://github.com/hypeJunction/Elgg-hypeDirectory/commit/cd4ca8f))


### BREAKING CHANGES

* releases: Plugin has been renamed into hypeDirectory and most of it has been
rewritten



<a name="1.0.0"></a>
# [1.0.0](https://github.com/hypeJunction/Elgg-hypeDirectory/compare/1.0.0...v1.0.0) (2016-09-16)


### Features

* **releases:** rename the plugin into hypeDirectory ([cd4ca8f](https://github.com/hypeJunction/Elgg-hypeDirectory/commit/cd4ca8f))


### BREAKING CHANGES

* releases: Plugin has been renamed into hypeDirectory and most of it has been
rewritten



