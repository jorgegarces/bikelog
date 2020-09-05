<?php

namespace App\Application\Service\Bike;

use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeBrand;
use App\Domain\Model\Bike\BikeDTO;
use App\Domain\Model\Bike\BikeModel;
use App\Domain\Model\Bike\BikeRepository;
use PHPUnit\Framework\InvalidArgumentException;

class SaveBikeUseCase
{
    private $bikeRepository;

    public function __construct(BikeRepository $bikeRepository)
    {
        $this->bikeRepository = $bikeRepository;
    }

    public function addBike(BikeDTO $bikeDTO)
    {
        try {
            $bike = $this->createFromDTO($bikeDTO);
            $this->bikeRepository->save($bike);
        } catch (InvalidArgumentException $e) {
            // TODO: Log exception
        }
    }

    private function createFromDTO(BikeDTO $bikeDTO): Bike
    {
        return new Bike(
            BikeBrand::createFromString($bikeDTO->getBrand()),
            BikeModel::createFromString($bikeDTO->getModel())
        );
    }
}
