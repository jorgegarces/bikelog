<?php

namespace App\Tests\unit\Domain\Model\Bike;

use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeId;
use App\Domain\Model\BikeInfo\BikeBrand;
use App\Domain\Model\BikeInfo\BikeModel;
use App\Domain\Model\BikeInfo\BikeYear;

class BikeBuilder
{
    private $id;
    private $brand;
    private $model;
    private $year;

    private function __construct()
    {
        $this->id = BikeId::createFromString('a10fff35-8870-4a54-ae9c-1eada2755187');
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
            $this->brand,
            $this->model,
            $this->year
        );
    }
}
