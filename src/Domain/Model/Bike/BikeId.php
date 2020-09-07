<?php

namespace App\Domain\Model\Bike;

class BikeId
{
    private $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function createFromString(string $id): self
    {
        return new self($id);
    }

    public function equals(BikeId $id): bool
    {
        return  $id->id === $this->id;
    }
}
