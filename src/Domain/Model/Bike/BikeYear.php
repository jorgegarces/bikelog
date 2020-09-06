<?php

namespace App\Domain\Model\Bike;

class BikeYear
{
    private $year;

    private function __construct(int $year)
    {
        $this->year = $year;
    }

    public static function createFromInt(int $year): self
    {
        return new BikeYear($year);
    }

    public function year()
    {
        return $this->year;
    }

    public function equals(BikeYear $year)
    {
        return $year->year() === $this->year;
    }
}
