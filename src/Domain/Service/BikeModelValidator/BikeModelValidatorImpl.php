<?php

namespace App\Domain\Service\BikeModelValidator;

use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeModel\BikeModelRepository;

class BikeModelValidatorImpl implements BikeModelValidator
{
    private $bikeModelRepository;

    public function __construct(BikeModelRepository $bikeModelRepository)
    {
        $this->bikeModelRepository = $bikeModelRepository;
    }

    public function validateModel(Bike $prospectBike)
    {
       $brand = $this->bikeModelRepository->findBrand($prospectBike->brand());
       $model = $this->bikeModelRepository->findModelForBrand(
            $prospectBike->brand(),
            $prospectBike->model()
        );

       if (null === $brand) {
           throw new BikeValidationException('Brand not found');
       }

       if (null === $model) {
           throw new BikeValidationException('Invalid model');
       }

       return $model;
    }
}