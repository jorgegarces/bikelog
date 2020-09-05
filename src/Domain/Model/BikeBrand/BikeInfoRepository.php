<?php

namespace App\Domain\Model\BikeBrand;

use App\Domain\Model\Bike\BikeModel;

interface BikeInfoRepository
{
    public function findBrand(BikeBrand $brand): ?BikeBrand;
    public function findModelForBrand(BikeBrand $brand, BikeModel $model): ?BikeModel;
}
