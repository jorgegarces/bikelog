<?php


namespace App\Domain\Model\Bike;


class BikeDTO
{
    private $brand;
    private $model;
    private $year;

    public function __construct(
        string $brand,
        string $model,
        int $year
    )
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
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
