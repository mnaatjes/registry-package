# Enforcing Registry Categories

To ensure the registry is robust and reliable, it's crucial to move from using free-form strings for categories to a more structured and enforceable system. This prevents typos and ensures consistency across the application.

Here are three common patterns to achieve this, ranging from simple to highly structured.

---

## 1. The "Allow-List" (Using Enums or Constants)

This is the most direct way to prevent typos and limit the available categories. You define a definitive list of all valid categories in one place. For PHP 8.1 and later, Enums are the recommended, type-safe approach.

### With PHP 8.1+ Enums
```php
<?php
// Define all valid categories in an Enum
enum RegistryCategory: string
{
    case Database = 'database';
    case Filesystem = 'filesystem';
    case Cache = 'cache';
    case Api = 'api';
    case App = 'app';
}

// Update RegistryMetaData to accept the Enum
class RegistryMetaData
{
    public function __construct(
        private readonly ?string $type,
        private readonly ?RegistryCategory $category // Use the Enum type
    ){
    }

    public function getCategory(): ?RegistryCategory { return $this->category; }
}

// Usage:
$meta = new RegistryMetaData(
    'string',
    RegistryCategory::Database // This is type-safe and will be autocompleted by an IDE
);
```
**Enforcement:** The type-hint (`RegistryCategory`) on the constructor provides the enforcement. Passing a simple string or an invalid case will cause an immediate error.

---

## 2. The Dynamic `CategoryManager`

This approach is more flexible and allows categories to be defined at runtime. You create a dedicated class just for managing the list of categories.

```php
<?php
class CategoryManager
{
    private array $categories = [];

    public function addCategory(string $name, string $description): void
    {
        $this->categories[$name] = $description;
    }

    public function categoryExists(string $name): bool
    {
        return isset($this->categories[$name]);
    }
}

// The ServiceRegistry would use it for validation
class ServiceRegistry
{
    private CategoryManager $categoryManager;

    public function __construct()
    {
        // ...
        $this->categoryManager = new CategoryManager();
        $this->categoryManager->addCategory('database', 'Settings for database connections.');
    }

    public function register(string $alias, mixed $value, array $metadata = []): void
    {
        $category = $metadata['category'] ?? null;

        // ENFORCEMENT HAPPENS HERE
        if ($category && !$this->categoryManager->categoryExists($category)) {
            throw new \Exception("Invalid category: '{$category}' is not a registered category.");
        }
        
        // ... rest of registration logic
    }
}
```
**Enforcement:** The `register` method actively checks with the `CategoryManager` before allowing the operation to continue.

---

## 3. The "Registry Facade" API (Most Robust)

In this pattern, the API design itself enforces the category, making it impossible for the developer to choose it. This is the most advanced and safest method.

```php
<?php
// A specialized facade for database settings
class DatabaseRegistry
{
    // The category is a private, unchangeable constant.
    private const CATEGORY = 'database';

    public function __construct(private ServiceRegistry $registry) {}

    public function addConnection(string $name, string $host): void
    {
        // The category is not passed in; it's hard-coded.
        $this->registry->register("database.connections.{$name}.host", $host, ['category' => self::CATEGORY]);
    }
}

// Usage:
$dbRegistry = new DatabaseRegistry(ServiceRegistry::getInstance());
$dbRegistry->addConnection('mysql_main', 'localhost');
```
**Enforcement:** This is the strictest method. To add a database setting, you *must* use the `DatabaseRegistry`, which guarantees the correct category is always used.

---

## 4. The "Magic" Manager (Hybrid Approach)

This advanced pattern combines the elegant, static-like syntax of an Enum with the runtime flexibility of the dynamic `CategoryManager`. It uses PHP's `__callStatic()` magic method to intercept calls to undefined static methods, providing a clean API for categories that are defined dynamically.

```php
<?php

namespace mnaatjes\Registry\Support;

use Exception;

class CategoryManager
{
    /**
     * Holds all registered category names.
     * @var array<string, string>
     */
    private static array $categories = [];

    /**
     * Registers a new category.
     */
    public static function add(string $name, string $description = ''): void
    {
        // Store the canonical name, keyed by a case-insensitive, normalized version.
        $normalizedName = strtolower($name);
        self::$categories[$normalizedName] = $name;
    }

    /**
     * Magic method to handle calls like CategoryManager::Database().
     * @throws Exception if the category does not exist.
     */
    public static function __callStatic(string $name, array $arguments): string
    {
        $normalizedName = strtolower($name);
        if (!isset(self::$categories[$normalizedName])) {
            throw new Exception("Registry category '{$name}' has not been registered.");
        }

        return self::$categories[$normalizedName];
    }
}
```

### Usage Example

```php
<?php

// 1. In your application's bootstrap file, you define the categories:
CategoryManager::add('Database', 'Settings for database connections.');
CategoryManager::add('Cache', 'Configuration for caching layers.');

// 2. Anywhere in your code, you can now use the clean, static-like syntax:
$dbCategory = CategoryManager::Database(); // Returns the string 'Database'

$meta = new RegistryMetaData(
    'string',
    CategoryManager::Database() // Easy to read and will be validated at runtime.
);

// 3. An invalid category will throw an exception, providing enforcement.
try {
    $invalid = CategoryManager::Api(); // Throws an Exception
} catch (Exception $e) {
    // "Registry category 'Api' has not been registered."
}
```
**Enforcement:** A call to an unregistered category results in a runtime `Exception` from the `__callStatic` method, making it impossible to use an invalid category.

---

## What are Enums?

An **Enum** (short for "Enumeration") is a special type that allows you to define a variable that can only be one of a small, predefined set of possible values. Think of a traffic light that can only be `RED`, `YELLOW`, or `GREEN`.

The main benefit of an Enum is to prevent bugs caused by typos in strings (e.g., `'database'` vs `'datbase'`).

An Enum provides:
1.  **Impossible to Make a Typo:** Using `RegistryCategory::Database` is safe. A typo like `RegistryCategory::Datbase` will cause an immediate error.
2.  **Type Safety:** A function can require a `RegistryCategory` as an argument, guaranteeing it only ever receives a valid, predefined value.
3.  **Clarity and Autocomplete:** The code becomes easier to read, and your code editor can help you by suggesting the available options.

In short, an Enum transforms a loose convention into a strict, safe, and self-documenting rule that is enforced by the PHP engine itself.
