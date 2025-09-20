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
    }
?>