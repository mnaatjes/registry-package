<?php

    namespace mnaatjes\Registry\Tests\Stubs;

    class NoRequiredProps {
        public function __construct(
            private string $name="Gemini",
            private int $age=2,
            private array $likes=["bugs", "cheese", "walks"]
        ){}

        /**
         * getters
         */
        public function getName():string{return $this->name;}
        public function getAge():int{return $this->age;}
        public function getLikes():array{return $this->likes;}
    }
?>