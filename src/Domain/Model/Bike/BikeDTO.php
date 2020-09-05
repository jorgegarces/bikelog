<?php


namespace App\Domain\Model\Bike;


class BikeDTO
{
    private $brand;
    private $model;

    public function __construct(
        string $brand,
        string $model
    )
    {
        $this->brand = $brand;
        $this->model = $model;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }
}
