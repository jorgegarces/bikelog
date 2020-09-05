<?php

namespace App\Application\Service\Bike;

use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeDTO;
use App\Domain\Model\Bike\BikeModel;
use App\Domain\Model\Bike\BikeRepository;
use App\Domain\Model\BikeBrand\BikeBrand;
use App\Domain\Model\BikeBrand\BikeBrandRepository;

class SaveBikeUseCase
{
    private $bikeRepository;
    private $bikeBrandRepository;

    public function __construct(
        BikeRepository $bikeRepository,
        BikeBrandRepository $bikeBrandRepository)
    {
        $this->bikeRepository = $bikeRepository;
        $this->bikeBrandRepository = $bikeBrandRepository;
    }

    public function addBike(BikeDTO $bikeDTO)
    {
        if (null === ($this->checkBrand($bikeDTO->getBrand()))) {
            throw new \InvalidArgumentException($bikeDTO->getBrand() . ' : Brand not found');
        }

        $bike = $this->createFromDTO($bikeDTO);
        $this->bikeRepository->save($bike);
    }

    private function createFromDTO(BikeDTO $bikeDTO): Bike
    {
        return new Bike(
            BikeBrand::createFromString($bikeDTO->getBrand()),
            BikeModel::createFromString($bikeDTO->getModel())
        );
    }

    private function checkBrand(string $brand): ?BikeBrand
    {
        return $this->bikeBrandRepository->searchBrand($brand);
    }
}
