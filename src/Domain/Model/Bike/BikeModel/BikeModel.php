<?php

namespace App\Domain\Model\Bike\BikeModel;

class BikeModel
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

    public function equals(BikeModel $model)
    {
        return $model->name === $this->name;
    }
}
