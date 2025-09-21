<?php

    namespace mnaatjes\Registry;

    use mnaatjes\Registry\Components\RegistryNode;
    use mnaatjes\Registry\Components\RegistryItem;
    use mnaatjes\Registry\Components\RegistryMetaData;

    class ServiceRegistry {
        /**
         * The instance of the registry
         * @var ServiceRegistry
         */
        private static ?ServiceRegistry $instance;

        /**
         * The root node of the registry
         * @var RegistryNode
         */
        private RegistryNode $root;

        /**
         * The constructor
         * @access private
         * @return void
         */
        private function __construct() {
            // Create the root node
            $this->root = new RegistryNode();
        }

        /**
         * Get the instance of the registry
         * @access public
         * @return ServiceRegistry
         */
        public static function getInstance(): ServiceRegistry {
            // If the instance has not been created yet, create it
            if (!isset(self::$instance)) {
                self::$instance = new ServiceRegistry();
            }

            // Return the instance
            return self::$instance;
        }

        public function register(string $alias, mixed $value, array $meta_data=[]): void{
            // Explode the alias into parts
            $alias = explode('.', $alias);

            /**
             * @var RegistryNode $currentNode
             */
            $currentNode = $this->root;

            // Find or make current node
            // Loop through the parts of the alias
            foreach ($alias as $key) {
                // If the current node has a child with the current part
                if ($currentNode->hasChild($key)) {
                    // Set the current node to the child
                    $currentNode = $currentNode->getChild($key);
                } else {
                    // Create a new node with the current part
                    $currentNode->setChild($key, new RegistryNode());
                    // Set the current node to the new node
                    $currentNode = $currentNode->getChild($key);
                }
            }

            // Node located
            // Generate meta-data
            $metaData = new RegistryMetaData(
                $meta_data["type"] ?? NULL,
                $meta_data["category"] ?? NULL
            );

            var_dump($currentNode->getKeys());
            var_dump($meta_data);

        }
    }
?>