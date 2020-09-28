<?php

namespace App\Domain\Model\Bike\ValueObjects;

class BikeYear
{
    private const MIN_YEAR = 1960;
    private $year;


    private function __construct(int $year)
    {
        $this->year = $year;
    }

    public static function createFromInt(int $year): self
    {
        self::validateYear($year);
        return new BikeYear($year);
    }

    /**
     * @param int $year
     * @throws BikeInfoException
     */
    private static function validateYear(int $year)
    {
        if ($year < self::MIN_YEAR || $year > (int) date("Y")) {
            throw new BikeInfoException('Invalid year');
        }
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
