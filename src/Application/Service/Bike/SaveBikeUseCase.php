<?php

namespace App\Application\Service\Bike;

use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeDTO;
use App\Domain\Model\Bike\BikeRepository;
use App\Domain\Service\BikeModelValidator\IBikeModelValidator;

class SaveBikeUseCase
{
    private $bikeRepository;
    private $bikeValidator;

    public function __construct(
        BikeRepository $bikeRepository,
        IBikeModelValidator $bikeInfoValidator
    ) {
        $this->bikeRepository = $bikeRepository;
        $this->bikeValidator = $bikeInfoValidator;
    }

    public function addBike(BikeDTO $requestDTO)
    {
        $bike = Bike::createFromDTO($requestDTO);
        $this->checkBikeModel($bike);
        $this->bikeRepository->save($bike);
    }

    private function checkBikeModel(Bike $prospectBike)
    {
        $this->bikeValidator->validateModel($prospectBike);
    }
}
