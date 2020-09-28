<?php

namespace App\Domain\Model\Bike\ValueObjects;

class BikePlateNumber
{
    private $plateNumber;

    public function __construct(string $plateNumber)
    {
        $this->plateNumber = $plateNumber;
    }

    public static function createFromString(string $plateNumber): self
    {
        self::validatePlateNumber($plateNumber);
       return new self($plateNumber);
    }

    /**
     * @param string $plateNumber
     * @throws BikeInfoException
     */
    private static function validatePlateNumber(string $plateNumber)
    {
        if ('' === $plateNumber || strlen($plateNumber) > 7) {
            throw new BikeInfoException('Invalid plate number');
        }

        // TODO: Improve plate number validation
    }

    public function equals(BikePlateNumber $plateNumber)
    {
        return $plateNumber->plateNumber === $this->plateNumber;
    }

    public function toString(): string
    {
        return $this->plateNumber;
    }
}
