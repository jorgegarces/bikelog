<?php

namespace App\Domain\Model\Bike;

use App\Domain\Model\BikeInfo\BikeBrand;
use App\Domain\Model\BikeInfo\BikeModel;
use App\Domain\Model\BikeInfo\BikeYear;

class Bike
{
    private $brand;
    private $model;
    private $year;

    public function __construct(
        BikeBrand $brand,
        BikeModel $model,
        BikeYear $year
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

    public function year(): BikeYear
    {
        return $this->year;
    }

    public static function createFromDTO(BikeDTO $requestDTO): self
    {
        return new self(
            BikeBrand::createFromString($requestDTO->getBrand()),
            BikeModel::createFromString($requestDTO->getModel()),
            BikeYear::createFromInt($requestDTO->getYear())
        );
    }
}
