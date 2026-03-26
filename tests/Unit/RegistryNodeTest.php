<?

use PHPUnit\Framework\TestCase;
use mnaatjes\Registry\Components\RegistryItem;
use mnaatjes\Registry\Components\RegistryNode;
use mnaatjes\Registry\Tests\Stubs\User;
use PHPUnit\Framework\Attributes\DataProvider;

    class RegistryNodeTest extends TestCase {

        public static function itemProvider(): iterable{
            yield "Standard Items" => [
                [
                    "item.string" => item("string value", "name1", "string"),
                    "item.int" => item("12", "age", "int"),
                    "item.user" => item(["Gemini", 2], "puppy", User::class)
                ]
            ];
        }

        #[DataProvider("itemProvider")]
        public function testResolveItems(array $items){
            foreach($items as $item){
                $this->assertTrue(is_a($item, RegistryItem::class));
            }
        }

        #[DataProvider("itemProvider")]
        public function testNewRegistryNodeInstanceCreation(array $items){
            // node
            $node = new RegistryNode();
            // Add
            foreach($items as $key => $item){
                $node->addChild($key, $item);
            }

            $this->assertTrue(is_a($node, RegistryNode::class));
            $this->assertTrue(is_array($node->getChildren()));

            $node->removeChild("item.int");

            $this->assertEquals(2, count($node->getChildren()));
        }
    }
?>