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
    }

?>