<?php

namespace App\Application\Service\Bike;

use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeDTO;
use App\Domain\Model\Bike\BikeModel;
use App\Domain\Model\Bike\BikeRepository;
use App\Domain\Model\BikeBrand\BikeBrand;
use App\Domain\Model\BikeBrand\BikeInfoRepository;
use InvalidArgumentException;

class SaveBikeUseCase
{
    private $bikeRepository;
    private $bikeBrandRepository;

    public function __construct(
        BikeRepository $bikeRepository,
        BikeInfoRepository $bikeBrandRepository
    )
    {
        $this->bikeRepository = $bikeRepository;
        $this->bikeBrandRepository = $bikeBrandRepository;
    }

    public function addBike(BikeDTO $requestDTO)
    {
        $this->checkBikeInfo($requestDTO);
        $this->bikeRepository->save($this->createFromDTO($requestDTO));
    }

    private function checkBikeInfo(BikeDTO $request): void
    {
        $bikeBrand = $this->checkBrand($request->getBrand());
        if (null === $bikeBrand) {
            throw new InvalidArgumentException($request->getBrand() . ' : Brand not found.');
        }

        $bikeModel = $this->checkModel($request->getBrand(), $request->getModel());
        if (null === $bikeModel) {
            throw new InvalidArgumentException($request->getModel() . ' : Model for that brand not found.');
        }
    }

    private function checkBrand(string $brand): ?BikeBrand
    {
        return $this->bikeBrandRepository
            ->findBrand(BikeBrand::createFromString($brand));
    }

    private function checkModel(string $brand, string $model)
    {
        return $this->bikeBrandRepository
            ->findModelForBrand(
                BikeBrand::createFromString($brand),
                BikeModel::createFromString($model));
    }

    private function createFromDTO(BikeDTO $bikeDTO): Bike
    {
        return new Bike(
            BikeBrand::createFromString($bikeDTO->getBrand()),
            BikeModel::createFromString($bikeDTO->getModel()),
            $bikeDTO->getYear()
        );
    }
}
