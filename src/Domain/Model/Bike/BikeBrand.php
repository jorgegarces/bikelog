<?php

namespace App\Domain\Model\Bike;

use Psr\Log\InvalidArgumentException;

class BikeBrand
{
    private static $brands = array('Yamaha', 'Honda');
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function createFromString(string $name): self
    {
        if (!in_array($name, self::$brands)) {
            throw new InvalidArgumentException('Bike brand not found: ' . $name);
        }
        return new self($name);
    }

    public function equals(BikeBrand $bikeBrand)
    {
        return $bikeBrand->name === $this->name;
    }
}
