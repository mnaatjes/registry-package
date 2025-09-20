<?php

namespace Reg\Components;
/**
 * @file src/RegistryItem.php
 *
 * @version 1.0.0
 */
class RegistryItem {

	private readonly $value;
	private readonly $metaData;

	/**
	 * Constructor
	 */ 
	public function __construct($value, RegistryMetaData $meta_data){
		// Assign Value
		$this->value = $value;

		// Assign Meta-data
		$this->metaData = $meta_data;
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
