<?php

namespace App\Infrastructure;

use App\Domain\Model\Bike\BikeModel\BikeBrand;
use App\Domain\Model\Bike\BikeModel\BikeModel;
use App\Domain\Model\Bike\BikeModel\BikeModelRepository;

class InMemoryBikeModelRepository implements BikeModelRepository
{
    public $brands = [
        'Yamaha' => [
            'R1',
            'R6',
        ],
        'Honda' => [
            'Fireblade',
            'CBR600RR',
        ],
    ];

    public function findBrand(BikeBrand $brand): ?BikeBrand
    {
        if (array_key_exists($brand->brand(), $this->brands)) {
            return $brand;
        }
        return null;
    }

    public function findModelForBrand(BikeBrand $brand, BikeModel $model): ?BikeModel
    {
        if (false !== array_search($model->model(), $this->brands[$brand->brand()])) {
            return $model;
        }
        return null;
    }
}
