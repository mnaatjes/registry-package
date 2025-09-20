<?php

namespace mnaatjes\Registry\Components;
/**
 * @file src/RegistryMetaData
 *
 */
class RegistryMetaData
{
	public function __construct(
		private readonly ?string $type,
		private readonly ?string $category
	){
	}

	public function getType(){return $this->type;}
	public function getCategory(){return $this->category;}
}
