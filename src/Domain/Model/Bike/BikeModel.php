<?php

namespace App\Domain\Model\Bike;

use Psr\Log\InvalidArgumentException;

class BikeModel
{
    private static $models = array('Fireblade', 'R1');
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function createFromString(string $name): self
    {
        if (!in_array($name, self::$models)) {
            throw new InvalidArgumentException('Bike brand not found: ' . $name);
        }

        return new self($name);
    }

    public function equals(BikeModel $model)
    {
        return $model->name === $this->name;
    }
}
