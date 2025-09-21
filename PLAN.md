# Registry Planning Document

## 1.0 Overview

### 1.1 Vision

To create a robust, standalone, and PSR-compliant PHP registry package based on OOP principles outlined in docs/references/ref-registry.md.

## 2.0 Features

### 2.1 Core Features

## 3.0 Directory Structure

```
.
│
├── src/
│   ├── Components/
│   │   ├── RegistryNode.php
│   │   ├── RegistryItem.php
│   │   └── RegistryMetaData.php
│   │
│   └── ServiceRegistry.php
│
├── tests/
│   ├── main.php
│   └── ...
│
├── composer.json
├── README.md
├── PLAN.md
└── TODO.md

```

## 4.0 Component Class Diagrams

This section contains the Mermaid class diagram for the core components of the PHP Registry package.

```mermaid
classDiagram
    direction TD

    class ServiceRegistry {
        <<Singleton>>
        -instance: ServiceRegistry
        -root: RegistryNode
        +getInstance(): ServiceRegistry
        +register(alias: string, value: mixed, metadata: array): void
        +lookup(alias: string): mixed
        +has(alias: string): bool
        -__construct()
    }

    class RegistryNode {
        -children: array
        +setChild(key: string, child: RegistryNode|RegistryItem): void
        +getChild(key: string): RegistryNode|RegistryItem|null
        +hasChild(key: string): bool
        +getChildren(): array
    }

    class RegistryItem {
        <<ValueObject>>
        -value: mixed
        -metaData: RegistryMetaData
        +__construct(value: mixed, metaData: RegistryMetaData)
        +getValue(): mixed
        +getMetaData(): RegistryMetaData
        +resolve(): mixed
    }

    class RegistryMetaData {
        <<ValueObject>>
        -type: string
        -category: string
        -description: string
        -tags: array
        +__construct(type: string, category: string)
        +getType(): string
        +getCategory(): string
    }

    class CategoryManager {
        <<Magic Methods>>
        -categories: array
        +add(name: string, description: string): void
        +exists(name: string): bool
        +__callStatic(name: string, arguments: array): string
    }

    ServiceRegistry "1" o-- "1" RegistryNode : has root
    RegistryNode "1" o-- "*" RegistryNode : has children
    RegistryNode "1" o-- "*" RegistryItem : has leaves
    RegistryItem "1" *-- "1" RegistryMetaData : has
```
