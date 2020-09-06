<?php

namespace App\Application\Service\Bike;

use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeDTO;
use App\Domain\Model\Bike\BikeModel;
use App\Domain\Model\Bike\BikeRepository;
use App\Domain\Model\BikeBrand\BikeBrand;
use App\Domain\Service\BikeInfoValidator\BikeInfoValidator;

class SaveBikeUseCase
{
    private $bikeRepository;
    private $bikeInfoValidator;

    public function __construct(
        BikeRepository $bikeRepository,
        BikeInfoValidator $bikeInfoValidator
    )
    {
        $this->bikeRepository = $bikeRepository;
        $this->bikeInfoValidator = $bikeInfoValidator;
    }

    public function addBike(BikeDTO $requestDTO)
    {
        $this->checkBikeInfo($requestDTO->getBrand(), $requestDTO->getModel());
        $this->bikeRepository->save($this->createBikeFromDTO($requestDTO));
    }

    private function createBikeFromDTO(BikeDTO $bikeDTO): Bike
    {
        return new Bike(
            BikeBrand::createFromString($bikeDTO->getBrand()),
            BikeModel::createFromString($bikeDTO->getModel()),
            $bikeDTO->getYear()
        );
    }

    private function checkBikeInfo($requestBrand, $requestModel)
    {
        $this->bikeInfoValidator->checkBikeInfo(
            BikeBrand::createFromString($requestBrand),
            BikeModel::createFromString($requestModel)
        );
    }
}
