<?php

namespace mnaatjes\Registry\Components;
/**
 * @file src/Components/RegistryNode.php
 *
 */
class RegistryNode {
	private array $children=[];

	public function setChild(string $key, RegistryNode|RegistryItem|NULL $child=NULL): void{
		$this->children[$key] = $child;	
	}

	public function getChild(string $key): RegistryNode|RegistryItem|NULL{return $this->children[$key];}

	public function getKeys(): array{return array_keys($this->children);}

	public function hasChild(string $key): bool{return isset($this->children[$key]);}

	public function getChildren():array {return $this->children;}
}
?>
