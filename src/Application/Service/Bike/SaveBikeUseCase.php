<?php

namespace App\Application\Service\Bike;

use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeDTO;
use App\Domain\Model\Bike\BikeRepository;
use App\Domain\Service\BikeValidator\BikeValidator;

class SaveBikeUseCase
{
    private $bikeRepository;
    private $bikeValidator;

    public function __construct(
        BikeRepository $bikeRepository,
        BikeValidator $bikeInfoValidator
    ) {
        $this->bikeRepository = $bikeRepository;
        $this->bikeValidator = $bikeInfoValidator;
    }

    public function addBike(BikeDTO $requestDTO)
    {
        $bike = Bike::createFromDTO($requestDTO);
        $this->checkBikeInfo($bike);
        $this->bikeRepository->save($bike);
    }

    private function checkBikeInfo(Bike $prospectBike)
    {
        $this->bikeValidator->validateBike($prospectBike);
    }
}
