# Registry Package Design Diagrams

This document provides detailed design diagrams for the core processes of the registry package.

---

## 1. Singleton Instance Creation

This sequence diagram shows how the `getInstance()` method ensures that only one instance of the `ServiceRegistry` is ever created, enforcing the Singleton pattern.

```mermaid
sequenceDiagram
    participant Client
    participant ServiceRegistry

    Client->>ServiceRegistry: getInstance()
    activate ServiceRegistry
    Note over ServiceRegistry: Check if private static $instance is null
    ServiceRegistry->>ServiceRegistry: new ServiceRegistry()
    Note over ServiceRegistry: Store new instance in static property
    ServiceRegistry-->>Client: return instance
    deactivate ServiceRegistry

    Client->>ServiceRegistry: getInstance()
    activate ServiceRegistry
    Note over ServiceRegistry: $instance is not null, return existing
    ServiceRegistry-->>Client: return instance
    deactivate ServiceRegistry
```

---

## 2. Data Flow (Register & Lookup)

This sequence diagram illustrates the two fundamental operations of the registry: writing data via `register()` and reading it back via `lookup()`.

```mermaid
sequenceDiagram
    participant Application as Application Code
    participant Registry as ServiceRegistry

    Application->>Registry: register('app.debug', true)
    activate Registry
    Registry->>Registry: Store `true` at key 'app.debug'
    deactivate Registry

    Note over Application, Registry: ... time passes ...

    Application->>Registry: lookup('app.debug')
    activate Registry
    Registry-->>Application: returns `true`
    deactivate Registry
```

---

## 3. Category Validation & Registration Flow

This sequence diagram shows the complete flow of how the `CategoryManager` is used. First, a category is defined during application bootstrap. Later, when client code calls `register()`, the `ServiceRegistry` uses the `CategoryManager`'s magic `__callStatic` method to validate the category and retrieve its canonical name before creating the `RegistryMetaData`.

```mermaid
sequenceDiagram
    participant Bootstrap
    participant ClientCode
    participant CategoryManager
    participant ServiceRegistry
    participant RegistryMetaData

    Bootstrap->>CategoryManager: add('Database', ...)
    note right of Bootstrap: Categories are defined once at runtime.

    ClientCode->>ServiceRegistry: register('db.host', 'localhost', meta)
    activate ServiceRegistry

    note over ServiceRegistry: Metadata array contains 'category' => CategoryManager::Database()
    ServiceRegistry->>CategoryManager: __callStatic('Database')
    activate CategoryManager
    note left of CategoryManager: Magic method validates category exists.
    CategoryManager-->>ServiceRegistry: returns 'Database'
    deactivate CategoryManager

    ServiceRegistry->>RegistryMetaData: new(type, 'Database')
    activate RegistryMetaData
    RegistryMetaData-->>ServiceRegistry: returns instance
    deactivate RegistryMetaData
    
    note over ServiceRegistry: ... proceeds with node traversal and item creation ...
    deactivate ServiceRegistry
```

---

## 4. Alias Parsing & Node Generation

This flowchart visualizes the internal logic of the `register()` method. It shows how a dot-notation alias is parsed to traverse and, if necessary, create the `RegistryNode` object graph.

```mermaid
flowchart TD
    A["Start register(alias, value, metadata)"] --> B{"Has 'category' in metadata?"}
    B -- Yes --> C{"CategoryManager::exists(category)?"}
    C -- No --> D["Throw InvalidCategoryException"]
    D --> Z[End]
    C -- Yes --> E["Explode alias string to keys"]
    B -- No --> E
    E --> F["current_node = root_node"]
    F --> G{"Loop through keys (except last)"}
    G -- Next key --> H{"current_node.hasChild(key)?"}
    H -- No --> I["new_node = new RegistryNode()"]
    I --> J["current_node.setChild(key, new_node)"]
    J --> K["current_node = new_node"]
    H -- Yes --> L["current_node = current_node.getChild(key)"]
    L --> G
    K --> G
    G -- Loop finished --> M["item = new RegistryItem(value)"]
    M --> N["current_node.setChild(lastKey, item)"]
    N --> Z
```

---

## 4. Value Resolution (Hydration)

This flowchart shows the logic of the `resolve()` method, which transforms a raw stored value into its final, usable form based on the instructions in its `RegistryMetaData`.

```mermaid
flowchart TD
    A["Start resolve()"] --> B{"Metadata has explicit type?"}
    B -- No --> C["Return Raw Value"]
    B -- Yes --> D{"Is type a scalar (int, bool, etc.)?"}
    D -- Yes --> E["Cast value to scalar type"]
    D -- No --> F["Assume type is a Class Name"]
    F --> G["Instantiate new Class(value)"]
    C --> Z[End]
    E --> Z
    G --> Z
```
