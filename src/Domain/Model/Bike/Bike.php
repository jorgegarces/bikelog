<?php


namespace App\Domain\Model\Bike;

use App\Domain\Model\BikeBrand\BikeBrand;

class Bike
{
    private $brand;
    private $model;

    public function __construct(
        BikeBrand $brand,
        BikeModel $model
    )
    {
        $this->brand = $brand;
        $this->model = $model;
    }

    public function brand(): BikeBrand
    {
        return $this->brand;
    }

    public function model(): BikeModel
    {
        return $this->model;
    }

    public function hasBrand(BikeBrand $brand)
    {
        return $brand === $this->brand;
    }
}
