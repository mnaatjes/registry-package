<?php

    namespace mnaatjes\Registry\Components;
    use mnaatjes\Registry\Components\RegistryItem;

    final class RegistryNode {

        private array $children=[];

        /**
         * Verifies (Node | Item) and pushes to node as child with key
         * 
         * @param string $key
         * @param RegistryNode|RegistryItem $child
         * 
         * @return void
         */
        public function addChild(string $key, RegistryNode|RegistryItem $child): void{
            $this->children[$key] = $child;
        }

        public function getChild(string $key): RegistryNode|RegistryItem{
            return $this->children[$key];
        }

        public function hasChild(string $key):bool{
            return array_key_exists($key, $this->children);
        }

        public function removeChild(string $key): void{
            unset($this->children[$key]);
        }

        public function getChildren(): array{
            return $this->children;
        }
    }

?>