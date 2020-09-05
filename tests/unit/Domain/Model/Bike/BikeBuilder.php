<?php

namespace App\Tests\unit\Domain\Model\Bike;

use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeBrand;
use App\Domain\Model\Bike\BikeModel;

class BikeBuilder
{
    private $brand;
    private $model;

    private function __construct()
    {
        $this->brand = BikeBrand::createFromString('Honda');
        $this->model = BikeModel::createFromString('Fireblade');
    }

    public static function aBike(): self
    {
        return new self();
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
            $this->brand,
            $this->model
        );
    }
}
