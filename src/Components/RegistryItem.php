<?php

namespace mnaatjes\Registry\Components;

/**
 * @file src/RegistryItem.php
 *
 * @version 1.0.0
 */
class RegistryItem {

	/**
	 * Constructor
	 */ 
	public function __construct(
		private readonly mixed $value,
		private readonly ?RegistryMetaData $metaData
	){

	}

	/**
	 * Resolve Stored Value
	 *
	 */ 
	public function resolve(){
		// Determine type from metaData
		$type = $this->metaData->getType();

		// Match and return resolved type

	}
}

?>
