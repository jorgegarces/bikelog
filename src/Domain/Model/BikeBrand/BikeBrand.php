<?php

namespace App\Domain\Model\BikeBrand;

class BikeBrand
{
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function createFromString(string $name): self
    {
        return new self($name);
    }

    public function equals(BikeBrand $bikeBrand)
    {
        return $bikeBrand->name === $this->name;
    }
}
