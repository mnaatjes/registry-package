<?php

namespace mnaatjes\Registry\Support;

use Exception;

final class Categories
{
    /**
     * The default categories provided by the package.
     */
    private const DEFAULT_CATEGORIES = [
        'String' => 'String values',
        'Integer' => 'Integer values',
        'Float' => 'Float values',
        'Boolean' => 'Boolean values',
        'Array' => 'Array values',
        'Object' => 'Object values',
        'Callable' => 'Callable values',
        'Resource' => 'Resource values',
        'Null' => 'Null values',
        'Mixed' => 'Mixed values',
        'File' => 'File paths',
        'Url' => 'URLs',
        'Email' => 'Email addresses',
        'Date' => 'Date values',
        'Json' => 'JSON strings',
        'Xml' => 'XML strings',
        'Yaml' => 'YAML strings',
        'Html' => 'HTML strings',
        'Css' => 'CSS strings',
        'Js' => 'JavaScript strings',
        'Image' => 'Image files',
        'Video' => 'Video files',
        'Audio' => 'Audio files',
        'Document' => 'Document files',
        'Archive' => 'Archive files',
        'Binary' => 'Binary data',
        'Text' => 'Text data',
        'Config' => 'Configuration data',
        'Env' => 'Environment variables',
        'Session' => 'Session data',
        'Cookie' => 'Cookie data',
        'Cache' => 'Cache data',
        'Log' => 'Log data',
        'Error' => 'Error data',
        'Exception' => 'Exception data',
        'Warning' => 'Warning data',
        'Info' => 'Informational data',
        'Debug' => 'Debug data',
        'Performance' => 'Performance data',
        'Security' => 'Security data',
        'User' => 'User data',
        'Admin' => 'Admin data',
        'System' => 'System data',
        'Custom' => 'Custom data',
        'Other' => 'Other data',
        'All' => 'All data types',
        'Connection' => 'Connection data',
        'Request' => 'Request data',
        'Response' => 'Response data',
        'Api' => 'API data',
        'Service' => 'Service data',
        'Module' => 'Module data',
        'Plugin' => 'Plugin data',
        'Theme' => 'Theme data',
        'Extension' => 'Extension data',
        'Component' => 'Component data',
        'Widget' => 'Widget data',
        'Template' => 'Template data',
        'Layout' => 'Layout data',
        'Menu' => 'Menu data',
        'Navigation' => 'Navigation data',
        'Permission' => 'Permission data',
        'Role' => 'Role data',
        'Group' => 'Group data',
        'Organization' => 'Organization data',
        'Project' => 'Project data',
        'Task' => 'Task data',
        'Event' => 'Event data',
        'Notification' => 'Notification data',
        'Message' => 'Message data',
        'Comment' => 'Comment data',
        'Review' => 'Review data',
        'Rating' => 'Rating data',
        'Feedback' => 'Feedback data',
        'Survey' => 'Survey data',
        'Report' => 'Report data',
        'Analytics' => 'Analytics data',
        'Metric' => 'Metric data',
        'Statistic' => 'Statistic data',
        'Trend' => 'Trend data',
        'Insight' => 'Insight data',
        'Benchmark' => 'Benchmark data',
        'Comparison' => 'Comparison data',
        'History' => 'History data',
        'Version' => 'Version data',
        'Changelog' => 'Changelog data',
        'License' => 'License data',
        'Copyright' => 'Copyright data',
        'Attribution' => 'Attribution data',
        'Credit' => 'Credit data',
        'Sponsor' => 'Sponsor data',
        'Donor' => 'Donor data',
        'Partner' => 'Partner data',
        'Affiliate' => 'Affiliate data',
        'Controller' => 'Controller data',
        'Model' => 'Model data',
        'View' => 'View data',
        'Helper' => 'Helper data',
        'Library' => 'Library data',
        'Framework' => 'Framework data',
        'Platform' => 'Platform data',
        'Environment' => 'Environment data',
        'Infrastructure' => 'Infrastructure data',
        'Database' => 'Database data',
        'Table' => 'Table data',
        'Column' => 'Column data',
        'Row' => 'Row data',
        'Index' => 'Index data',
        'Key' => 'Key data',
        'Constraint' => 'Constraint data',
        'Query' => 'Query data',
        'Transaction' => 'Transaction data',
        'Migration' => 'Migration data',
        'Seed' => 'Seed data',
        'Fixture' => 'Fixture data',
        'Test' => 'Test data',
        'Mock' => 'Mock data',
        'Stub' => 'Stub data',
        'Spy' => 'Spy data',
        'Assertion' => 'Assertion data',
        'Expectation' => 'Expectation data',
        'Coverage' => 'Coverage data',
        'Build' => 'Build data',
        'Deploy' => 'Deploy data',
    ];

    /**
     * Holds all registered category names.
     * @var array<string, string>
     */
    private static array $categories = [];

    /**
     * Tracks if the default categories have been loaded.
     * @var bool
     */
    private static bool $isLoaded = false;

    private static ?string $configFilepath = NULL;

    private static function normalizeName(string $name): string{
        // Normalize by trimming and converting to lowercase, spaces to underscores, and removing special characters
        return strtolower(preg_replace('/[^a-zA-Z0-9_]/', '_', trim($name)));
    }
    /**
     * Loads the default categories from the class constant.
     */
    private static function loadDefaults(): void{
        foreach (self::DEFAULT_CATEGORIES as $name => $description) {
            // Use a direct property access to avoid an infinite loop
            $normalizedName = self::normalizeName($name);
            //$normalizedName = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '_', trim($name)));
            self::$categories[$normalizedName] = $description;
        }
    }

    /**
     * Loads user-defined categories from a configuration file, if specified.
     * The configuration file should return an associative array of category names to descriptions.
     * If a category already exists, it will not be overwritten.
     */
    private static function loadUserCategories(): void{
        // Check if config filepath is not null and realpath exists
        if(self::$configFilepath !== null && file_exists(self::$configFilepath)){
            // Load user categories from the specified config file
            // Load as anonumous function to avoid variable scope issues
            $loadFunc = function(string $filepath){
                // Pull in the data
                $data = include $filepath;

                // Check if data is an array
                if(is_array($data)){

                    // Merge user categories, avoiding overwrites
                    foreach ($data as $name => $description) {

                        // Store category if not already exists
                        // Use a direct property access to avoid an infinite loop
                        $normalizedName = self::normalizeName($name);
                        // $normalizedName = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '_', trim($name)));
                        if(!isset(self::$categories[$normalizedName])){
                            self::$categories[$normalizedName] = $description;
                        }
                    }
                }
            };

            // Call the function with the filepath
            $loadFunc(self::$configFilepath);

        } else {
            // No user categories to load
            return;
        }
    }
    /**
     * Ensures defaults are loaded before proceeding.
     */
    private static function ensureLoaded(): void{
        // Check if already loaded
        if (self::$isLoaded === false) {
            // Load Defaults
            self::loadDefaults();

            // Load User Supplied Categories
            self::loadUserCategories();

            // Sort by keys alphabetically
            ksort(self::$categories);

            // Mark as loaded
            self::$isLoaded = true;
        }
    }

    /**
     * Registers a new category.
     */
    public static function add(string $name, string $description = ''): void{
        // Check if loaded
        self::ensureLoaded();

        // Normalize name
        $normalizedName = self::normalizeName($name);
        
        // Check if already exists
        if (isset(self::$categories[$normalizedName])) {
            throw new Exception("Registry category '{$name}' has already been registered.");
        }

        // Store category
        self::$categories[$normalizedName] = $description ?: $name;
    }

    /**
     * Magic method to handle calls like CategoryManager::Database().
     * @throws Exception if the category does not exist.
     */
    public static function __callStatic(string $name, array $arguments): string
    {
        // Check if loaded
        self::ensureLoaded();

        // Normalize name
        $normalizedName = strtolower($name);

        // Check if exists
        if(self::has($name)){
            // Return normalized name as meta-data category identifier
            return $normalizedName;
        } else {
            throw new Exception("Registry category '{$name}' does not exist.");
        }
    }

    /**
     * Checks if a category exists.
     */
    public static function has(string $name): bool{
        self::ensureLoaded();
        return isset(self::$categories[self::normalizeName($name)]);
    }

    public static function all(): array{
        self::ensureLoaded();
        return self::$categories;
    }

    public static function clear(): void{
        self::$categories = [];
        self::$isLoaded = false;
    }

    public static function reset(): void{
        self::clear();
        self::ensureLoaded();
    }

    public static function count(): int{
        self::ensureLoaded();
        return count(self::$categories);
    }

    public static function isEmpty(): bool{
        self::ensureLoaded();
        return empty(self::$categories);
    }

    public static function setConfigFilepath(string $path): void{
        // Check if file exists
        if(file_exists($path) && is_readable($path)){
            self::$configFilepath = realpath($path);
            // Reset to reload categories
            self::reset();
        } else {
            throw new Exception("Configuration file '{$path}' does not exist or is not readable.");
        }
    }
}
