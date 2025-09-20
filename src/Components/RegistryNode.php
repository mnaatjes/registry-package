<?php

namespace Reg\Components;
/**
 * @file src/Components/RegistryNode.php
 *
 */
class RegistryNode {
	private array $children=[];

	public function setChild(string $key, RegistryNode|RegistryItem $child): void{
		$this->children[$key] = $child;	
	}

	public function getChild(string $key): RegistryNode|RegistryItem|NULL{
		return $this->children[$key];	
	}

	public function hasChild(string $key): bool{}

	public function getChildren(){}
}
?>
