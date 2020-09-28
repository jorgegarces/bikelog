<?php

namespace App\Domain\Model\Bike;

use App\Domain\Model\Bike\BikeModel\BikeBrand;
use App\Domain\Model\Bike\BikeModel\BikeModel;
use App\Domain\Model\Bike\ValueObjects\BikeId;
use App\Domain\Model\Bike\ValueObjects\BikePlateNumber;
use App\Domain\Model\Bike\ValueObjects\BikeYear;

class Bike
{
    private $id;
    private $plateNumber;
    private $brand;
    private $model;
    private $year;

    public function __construct(
        BikeId $id,
        BikePlateNumber $plateNumber,
        BikeBrand $brand,
        BikeModel $model,
        BikeYear $year
    )
    {
        $this->id = $id;
        $this->plateNumber = $plateNumber;
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

    public function plateNumber(): BikePlateNumber
    {
        return $this->plateNumber;
    }

    public static function createFromDTO(BikeDTO $requestDTO): self
    {
        return new self(
            BikeId::createFromString($requestDTO->getId()),
            BikePlateNumber::createFromString($requestDTO->getPlateNumber()),
            BikeBrand::createFromString($requestDTO->getBrand()),
            BikeModel::createFromString($requestDTO->getModel()),
            BikeYear::createFromInt($requestDTO->getYear())
        );
    }
}
