# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.1.0] - 2026-03-26

### Added
- **Core Architecture:** Implemented hierarchical `RegistryNode` for tree-based configuration storage.
- **Value Objects:** Created `RegistryItem` and `RegistryMetaData` for structured data handling.
- **Type Resolution:** Added `RegistryItem::resolve()` with support for:
    - Scalar types (int, bool, string, array).
    - Automatic object instantiation via PHP Reflection.
    - Handling of constructor arguments (single values, indexed arrays, and associative arrays for property population).
- **Helper Functions:** Introduced `item()` helper for streamlined `RegistryItem` creation.
- **Documentation:** Added comprehensive design guides (`docs/ref-registry.md`, `docs/DESIGN.md`, `PLAN.md`).
- **Testing Suite:** Established unit tests for `RegistryItem`, `RegistryNode`, and `RegistryMetaData` with 100% pass rate.
- **Composer Integration:** Configured PSR-4 autoloading and added `composer test` script.

### Changed
- **Restructure:** Migrated from a flat structure to a PSR-4 compliant namespace (`mnaatjes\Registry`).
- **Environment:** Transitioned from Docker-based development to native host PHP (8.3.6).
- **Git:** Updated `.gitignore` to exclude environment-specific files (.devcontainer, Docker, vendor, tests).

### Removed
- Legacy Dockerfile and docker-compose.yml configurations.
- Old flat source files in favor of the new `src/` hierarchy.
