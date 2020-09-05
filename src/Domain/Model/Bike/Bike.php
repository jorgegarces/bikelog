<?php

namespace App\Domain\Model\Bike;

use App\Domain\Model\BikeBrand\BikeBrand;

class Bike
{
    private $brand;
    private $model;
    private $year;

    public function __construct(
        BikeBrand $brand,
        BikeModel $model,
        int $year
    )
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
    }

    public function brand(): BikeBrand
    {
        return $this->brand;
    }

    public function model(): BikeModel
    {
        return $this->model;
    }

    public function year(): int
    {
        return $this->year;
    }
}
