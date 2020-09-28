<?php

namespace App\Domain\Model\Bike\ValueObjects;

class BikeId
{
    private const UUID_PATTERN = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';
    private $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function createFromString(string $id): self
    {
        self::validateId($id);
        return new self($id);
    }

    /**
     * @param string $id
     * @throws BikeInfoException
     */
    private static function validateId(string $id): void
    {
        if ((preg_match(self::UUID_PATTERN, $id) !== 1)) {
            throw new BikeInfoException('Invalid Id');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function equals(BikeId $id): bool
    {
        return  $id->id === $this->id;
    }
}
