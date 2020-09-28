<?php

namespace App\Tests\unit\Domain\Model\Bike;

use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeModel\BikeBrand;
use App\Domain\Model\Bike\BikeModel\BikeModel;
use App\Domain\Model\Bike\ValueObjects\BikeId;
use App\Domain\Model\Bike\ValueObjects\BikePlateNumber;
use App\Domain\Model\Bike\ValueObjects\BikeYear;

class BikeBuilder
{
    private $id;
    private $plateNumber;
    private $brand;
    private $model;
    private $year;

    private function __construct()
    {
        $this->id = BikeId::createFromString('a10fff35-8870-4a54-ae9c-1eada2755187');
        $this->plateNumber = BikePlateNumber::createFromString('0000AAA');
        $this->brand = BikeBrand::createFromString('Honda');
        $this->model = BikeModel::createFromString('Fireblade');
        $this->year = BikeYear::createFromInt(2000);
    }

    public static function aBike(): self
    {
        return new self();
    }

    public function withId(BikeId $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function withPlateNumber(BikePlateNumber $plateNumber): self
    {
        $this->plateNumber = $plateNumber;
        return $this;
    }

    public function withBrand(BikeBrand $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    public function withModel(BikeModel $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function build(): Bike
    {
        return new Bike(
            $this->id,
            $this->plateNumber,
            $this->brand,
            $this->model,
            $this->year
        );
    }
}
