<?php

    namespace mnaatjes\Registry\Tests\Stubs;

    class User {
        public function __construct(
            private string $name,
            private int $age=9,
            private array $likes=["springs", "socks", "catnip"]
        ){}

        /**
         * getters
         */
        public function getName():string{return $this->name;}
        public function getAge():int{return $this->age;}
        public function getLikes():array{return $this->likes;}
    }

?>