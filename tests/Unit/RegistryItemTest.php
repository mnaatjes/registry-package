<?php

    namespace mnaatjes\Registry\Tests\Unit;
    use mnaatjes\Registry\Components\RegistryItem;
    use mnaatjes\Registry\Components\RegistryMetaData;
use mnaatjes\Registry\Tests\Stubs\NoRequiredProps;
use mnaatjes\Registry\Tests\Stubs\TakesArray;
use PHPUnit\Framework\Attributes\DataProvider;
    use PHPUnit\Framework\TestCase;
    use mnaatjes\Registry\Tests\Stubs\User;

    class RegistryItemTest extends TestCase {
        /**
         * Test new Item Instance
         */
        public function testNewInstance(){
            $instance = new RegistryItem(
                "",
                $this->createMock(RegistryMetaData::class)
            );

            $this->assertInstanceOf(RegistryItem::class, $instance);
        }

        /**
         * Test Resolving an integer
         */
        public function testResolveInteger(){
            $default = new RegistryItem("12", RegistryMetaData::make("", "int"));
            $this->assertInstanceOf(RegistryItem::class, $default);
            $this->assertTrue(is_int($default->resolve()));
            $this->assertFalse(!is_int($default->resolve()));
            $this->assertEquals(12, $default->resolve());

            $fail = RegistryItem::make("12",RegistryMetaData::make("fail","string"));
            $this->assertFalse(is_int($fail->resolve()));
        }

        /**
         * Test MetaData factory
         */
        public function testFactoryMethod(){
            $obj = RegistryItem::make(
                "this is a string value",
                RegistryMetaData::make("test.item", "string")
            );

            $this->assertInstanceOf(RegistryItem::class, $obj);
            $this->assertTrue(is_string($obj->resolve()));
            $this->assertEquals("this is a string value", $obj->resolve());
        }


        /**
         * Data Provider: integer type
         */
        public static function intProvider(): iterable{
            yield "Working integer" => [
                "Returns valid integer 12",
                RegistryItem::make(
                    "12",
                    RegistryMetaData::make("", "int")
                ),
                12
            ];

            yield "Resolves to string" => [
                "Fails to resolve",
                RegistryItem::make(
                    "12",
                    RegistryMetaData::make("", "string")
                ), 
                "12"
            ];
        }

        /**
         * Test integer type with resolve
         */
        #[DataProvider("intProvider")]
        public function testIntegers(string $message, RegistryItem $item, mixed $expected): void{
            $result = $item->resolve();
            $this->assertEquals($expected, $result);
        }

        /**
         * Test array type 
         */
        public function testIsArray(){
            $obj = RegistryItem::make(
                ["a", "b", "c"],
                RegistryMetaData::make("name", "list")
            );

            $this->assertInstanceOf(RegistryItem::class, $obj);
            $this->assertTrue(is_array($obj->resolve()));
        }

        /**
         * TestObject
         * 
         */
        public function testObject(){
            $obj = RegistryItem::make(
                new RegistryItem([], RegistryMetaData::make("", "", "")),
                RegistryMetaData::make("name", "object")
            );

            $this->assertTrue(is_object($obj->resolve()));
        }

        public function testResolvedInstance(){

            $item = RegistryItem::make("Apollo", RegistryMetaData::make(
                "Apollo",
                User::class
            ));

            $this->assertTrue(is_a($item->resolve(), User::class));
        }

        public function testResolveClassTakesArray(){
            $item = RegistryItem::make(
                [],
                RegistryMetaData::make("test", TakesArray::class)
            );

            $this->assertTrue(is_a($item->resolve(), TakesArray::class));
        }

        public function testUserResolveFromArray(){
            $item = RegistryItem::make(
                [
                    "Apollo",
                    12,
                    ["bugs"]
                ],
                RegistryMetaData::make("user", User::class)
            );

            $user = $item->resolve();
            $this->assertTrue(is_a($user, User::class));
            $this->assertEquals("Apollo", $user->getName());
            $this->assertEquals(12, $user->getAge());
            $this->assertEquals(["bugs"], $user->getLikes());
        }

        public function testResolveNoRequiredArgs(){
            $item = RegistryItem::make(
                [
                    "likes" => ["walks", "lunch"]
                ],
                RegistryMetaData::make("gemmi", NoRequiredProps::class)
            );

            $puppy = $item->resolve();

            $this->assertTrue(is_a($puppy, NoRequiredProps::class));
        }
    }

?>