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

## 3. Alias Parsing & Node Generation

This flowchart visualizes the internal logic of the `register()` method. It shows how a dot-notation alias is parsed to traverse and, if necessary, create the `RegistryNode` object graph.

```mermaid
flowchart TD
    A["Start register(alias, value)"] --> B["Explode alias string to keys"]
    B --> C["current_node = root_node"]
    C --> D{"Loop through keys (except last)"}
    D -- Next key --> E{"current_node.hasChild(key)?"}
    E -- No --> F["new_node = new RegistryNode()"]
    F --> G["current_node.setChild(key, new_node)"]
    G --> H["current_node = new_node"]
    E -- Yes --> I["current_node = current_node.getChild(key)"]
    I --> D
    H --> D
    D -- Loop finished --> J["item = new RegistryItem(value)"]
    J --> K["current_node.setChild(lastKey, item)"]
    K --> Z[End]
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
