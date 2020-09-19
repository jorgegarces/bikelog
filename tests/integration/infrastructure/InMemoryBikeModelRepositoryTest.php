<?php

namespace App\Tests\integration\infrastructure;

use App\Domain\Model\Bike\BikeModel\BikeBrand;
use App\Domain\Model\Bike\BikeModel\BikeModel;
use App\Infrastructure\InMemoryBikeModelRepository;
use PHPUnit\Framework\TestCase;

class InMemoryBikeModelRepositoryTest extends TestCase
{
    private $inMemoryBikeModelRepository;

    protected function setUp(): void
    {
        $this->inMemoryBikeModelRepository = new InMemoryBikeModelRepository();
    }

    /** @test */
    public function should_return_a_valid_bike_brand_if_it_exists()
    {
        $aValidBikeBrand = BikeBrand::createFromString('Yamaha');

        $bikeBrand = $this->inMemoryBikeModelRepository->findBrand($aValidBikeBrand);

        self::assertEquals($aValidBikeBrand, $bikeBrand);
    }

    /** @test */
    public function should_return_null_if_brand_does_not_exist()
    {
        $aBikeBrand = BikeBrand::createFromString('an invalid bike brand');

        self::assertNull($this->inMemoryBikeModelRepository->findBrand($aBikeBrand));
    }

    /** @test */
    public function should_return_a_valid_model_if_it_exists_for_a_given_brand()
    {
        $aValidBikeBrand = BikeBrand::createFromString('Yamaha');
        $aValidBikeModel = BikeModel::createFromString('R1');

        $bikeModel = $this->inMemoryBikeModelRepository
            ->findModelForBrand(
                $aValidBikeBrand,
                $aValidBikeModel
            );

        self::assertEquals($aValidBikeModel, $bikeModel);
    }

    /** @test */
    public function should_return_null_if_model_does_not_exist_for_brand()
    {
        $aValidBikeBrand = BikeBrand::createFromString('Yamaha');
        $anInvalidBikeModel = BikeModel::createFromString('R2');

        $bikeModel = $this->inMemoryBikeModelRepository
            ->findModelForBrand(
                $aValidBikeBrand,
                $anInvalidBikeModel
            );

        self::assertNull($bikeModel);
    }
}
