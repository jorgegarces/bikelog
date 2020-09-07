<?php

namespace App\Domain\Model\BikeInfo;

interface BikeInfoRepository
{
    public function findBrand(BikeBrand $brand): ?BikeBrand;
    public function findModelForBrand(BikeBrand $brand, BikeModel $model): ?BikeModel;
}
