# Registry - PSR-Compliant PHP Registry

A simple, standalone, and PSR-compliant PHP registry package built on OOP principles.

**Current Version:** v0.1.0

## 1.0 Overview

The Registry pattern provides a centralized, globally accessible container for application-wide data and configuration. This package implements a robust, object-oriented version of the pattern, focusing on type safety and structured metadata.

## 2.0 Core Components

- **RegistryNode:** Manages the hierarchical tree structure, allowing for organized, nested configuration.
- **RegistryItem:** A Value Object that stores raw values and handles resolution into usable types or objects using PHP Reflection.
- **RegistryMetaData:** Provides structured information about each registry entry, including name, type, and descriptive tags.
- **item() Helper:** A convenient global function for rapid creation of `RegistryItem` instances.

## 3.0 Installation

Ensure you have PHP 8.1+ and the following extensions installed:
- `reflection`
- `pcre`
- `json`
- `mbstring`

```bash
composer install
```

## 4.0 Testing

The project uses PHPUnit for unit testing.

```bash
composer test
```

## 5.0 License

MIT
