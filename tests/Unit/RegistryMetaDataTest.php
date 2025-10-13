<?php

    namespace mnaatjes\Registry\Tests\Unit;
    use PHPUnit\Framework\TestCase;
    use mnaatjes\Registry\Components\RegistryMetaData;
    
    class RegistryMetaDataTest extends TestCase {
        /**
         * Creates new MetaData object
         */
        public function testCreateObject(){
            $metaData = new RegistryMetaData(
                "this is a name",
                "type",
                NULL,
                ["boy", "cat", "fish"]
            );

            $this->assertInstanceOf(RegistryMetaData::class, $metaData);
        }

        /**
         * 
         */
        public function testGetMetaData(){
            $metaData = new RegistryMetaData(
                "banana",
                "fruit",
                NULL,
                ["seeds", "yellow", "phallic"]
            );

            $this->assertInstanceOf(RegistryMetaData::class, $metaData);
            $this->assertEquals("fruit", $metaData->getType());
            $this->assertEquals("banana", $metaData->getName());
            $this->assertTrue(is_array($metaData->getTags()));
        }

        /**
         * 
         */
        public function testFactoryMethod(){
            $obj = RegistryMetaData::make(
                "",
                "type", 
                NULL,
                ["","",""]
            );

            $this->assertInstanceOf(RegistryMetaData::class, $obj);
        }
    } 
?>