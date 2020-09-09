<?php

namespace App\Domain\Model\Bike;

use App\Domain\Model\Bike\ValueObjects\BikeId;
use App\Domain\Model\Bike\ValueObjects\BikeYear;
use App\Domain\Model\BikeInfo\BikeBrand;
use App\Domain\Model\BikeInfo\BikeModel;

class Bike
{
    private $id;
    private $brand;
    private $model;
    private $year;

    public function __construct(
        BikeId $id,
        BikeBrand $brand,
        BikeModel $model,
        BikeYear $year
    )
    {
        $this->id = $id;
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
    }

    public function id(): BikeId
    {
        return $this->id;
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
            BikeId::createFromString($requestDTO->getId()),
            BikeBrand::createFromString($requestDTO->getBrand()),
            BikeModel::createFromString($requestDTO->getModel()),
            BikeYear::createFromInt($requestDTO->getYear())
        );
    }
}
