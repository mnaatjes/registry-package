<?php

    namespace mnaatjes\Registry\Components;

    readonly class RegistryMetaData {
        /**
         * Constructor
         * 
         * @param string $name
         * @param string $type
         * @param string|NULL $description
         * @param array $tags
         * 
         */
        public function __construct(
            private readonly string $name,
            private readonly string $type,
            private readonly ?string $description=NULL,
            private readonly array $tags=[]
        ){}

        /**
         * Getters
         */
        public function getName(): string{return $this->name;}
        public function getType(): string{return $this->type;}
        public function getDescription(): ?string{return $this->description;}
        public function getTags(): array{return $this->tags;}

        /**
         * Creates and returns a new MetaData instance
         * 
         * @param string $name
         * @param string $type
         * @param string|NULL $description
         * @param array $tags
         * 
         * @return RegistryMetaData
         */
        public static function make(
            string $name,
            string $type,
            ?string $description=NULL,
            array $tags=[]
        ): RegistryMetaData{
            return new self(
                $name,
                $type,
                $description,
                $tags
            );
        }
    }
?>