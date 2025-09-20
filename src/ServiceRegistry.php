<?php

    namespace mnaatjes\Registry;

    use mnaatjes\Registry\Components\RegistryNode;
    use mnaatjes\Registry\Components\RegistryItem;
    use mnaatjes\Registry\Components\RegistryMetaData;

    class ServiceRegistry {
        private static ?ServiceRegistry $instance;
        private RegistryNode $root;

        private function __construct() {
            // Create the root node
            $this->root = new RegistryNode();
        }

        public static function getInstance(): ServiceRegistry {
            // If the instance has not been created yet, create it
            if (!isset(self::$instance)) {
                self::$instance = new ServiceRegistry();
            }

            // Return the instance
            return self::$instance;
        }
    }
?>