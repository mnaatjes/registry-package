<?php

    namespace mnaatjes\Registry\Components;
    use mnaatjes\Registry\Components\RegistryMetaData;
use ReflectionClass;

    /**
     * Registry Item
     * 
     * - Works on the premise of "write-raw -> read-resolved"
     */
    final class RegistryItem {

        public function __construct(
            private mixed $value,
            private readonly RegistryMetaData $metaData
        ){}

        /**
         * Returns the raw value (unresolved by type)
         * @return mixed
         */
        public function getValue(): mixed{return $this->value;}
        
        /**
         * Returns the metaData object
         * 
         * @return RegistryMetaData
         */
        public function getMetaData(): RegistryMetaData {return $this->metaData;}

        /**
         * Returns value after type resolution
         * 
         * @return mixed
         */
        public function resolve(): mixed{
            // Use $type to determine resolved value
            return match($this->metaData->getType()){
                // Object, NULL, Empty (return raw value)
                "obj", "object", NULL, "" => $this->value,
                // Boolean
                "bool", "boolean" => (bool)$this->value,
                // Array
                "array", "arr", "list" => (array)$this->value,
                // Whole Number
                "int", "integer", "number" => (int)$this->value,
                // String
                "string" => (string)$this->value,
                // Default: Resolve Class
                default => $this->resolveClass($this->metaData->getType(), $this->value)
            };
        }

        private function resolveClass(string $className, mixed $value): object{
            // Determine if object exists
            if(!class_exists($className)){
                // Class cannot be found
                throw new \Exception("Unable to determine Class Name from: " . $className);
            }

            // Class Exists
            // Create Reflection
            $reflection = new ReflectionClass($className);
            
            // Declare constructor
            $constructor = $reflection->getConstructor();
            
            // Determine if class does not have a Public Construct
            if($constructor && !$constructor->isPublic()){
                throw new \Exception("Cannot resolve instance of {$className} without a public constructor!");
            }

            // Check number of arguments
            $numArgs = $constructor->getNumberOfRequiredParameters();

            // Determine if number of arguments exceeds 1 without an array as $value
            if($numArgs > 1 && !is_array($value)){
                // Multiple Arguments Require an array
                throw new \Exception("Cannot resolve {$className} in Registry! Nultiple arguments require an array of values");
            }

            // Determine if construct takes an array
            // Determine number of arguments
            // Find params
            $params = $constructor->getParameters();
            if(is_array($value) && !empty($params) && $numArgs === 1 && ($params[0]->getType())->getName() === 'array'){
                // Return new instance of ReflectionClass
                // with array as singular, required parameter
                return $reflection->newInstance($value);
            }

            // Determine if array is NOT assoc
            // Match number of arguments
            if(is_array($value) && array_is_list($value)){
                // Return new instance
                // from indexed array of parameters
                return $reflection->newInstanceArgs($value);
            }

            // Determine if class does not have Construct
            // or no parameters required
            // and value is an assoc array
            if((!$constructor || $numArgs === 0) && (is_array($value) && !array_is_list($value))){
                // Create instance and populate
                $instance = $reflection->newInstance();

                // Populate properties
                foreach($value as $propName=>$propValue){
                    // Check property name exists
                    // Ensure property is public
                    if($reflection->hasProperty($propName) && ($reflection->getProperty($propName))->isPublic()){
                        // Assign property to instance
                        ($reflection->getProperty($propName))->setValue($instance, $propValue);
                    }
                }

                // Return reflected instance
                return $instance;
            }

            // Final Check:
            // Single value for single required argument
            if($numArgs === 1){
                return new $className($value);
            } else {
                // Cannot Resolve
                throw new \Exception("Could not resolve {$className} given provided type and value");
            }
        }

        /**
         * Factory Method
         */
        public static function make(mixed $value, RegistryMetaData $metaData): RegistryItem {
            return new self($value, $metaData);
        }
    }
?>