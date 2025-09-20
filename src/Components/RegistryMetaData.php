<?php

namespace Reg\Components;
/**
 * @file src/RegistryMetaData
 *
 */
class RegistryMetaData
{

	private ?string $type;
	private ?string $category;

	public function __construct(string $type, string $category){
		$this->type 	= $type;
		$this->category = $category;
	}

	public function getType(){return $this->type;}
	public function getCategory(){return $this->category;}
}
