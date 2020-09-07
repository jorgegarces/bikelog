<?php

namespace App\Domain\Model\Bike;

class BikeDTO
{
    private $brand;
    private $model;
    private $year;
    private $id;

    public function __construct(
        string $id,
        string $brand,
        string $model,
        int $year
    )
    {
        $this->id = $id;
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getYear(): int
    {
        return $this->year;
    }
}
