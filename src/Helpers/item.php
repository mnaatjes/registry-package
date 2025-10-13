<?php

    use mnaatjes\Registry\Components\RegistryItem;
    use mnaatjes\Registry\Components\RegistryMetaData;
    /**
     * Helper method for RegistryItem::make()
     */
    // Check for existing method name
    if(!function_exists('item')){
        /**
         * @return RegistryItem
         */
        function item(mixed $value, string $name, string $type, string $description="", array $tags=[]){
            // Assemble and return
            return RegistryItem::make(
                $value,
                RegistryMetaData::make(
                    $name,
                    $type,
                    $description,
                    $tags
                )
            );
        }
    }

?>