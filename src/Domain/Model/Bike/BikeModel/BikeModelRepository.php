<?php

namespace App\Domain\Model\Bike\BikeModel;

interface BikeModelRepository
{
    public function findBrand(BikeBrand $brand): ?BikeBrand;
    public function findModelForBrand(BikeBrand $brand, BikeModel $model): ?BikeModel;
}
