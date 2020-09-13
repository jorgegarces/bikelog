<?php

namespace App\Tests\unit\Domain\Service\BikeBrandValidator;

use App\Domain\Model\Bike\BikeModel\BikeBrand;
use App\Domain\Model\Bike\BikeModel\BikeModel;
use App\Domain\Model\Bike\BikeModel\BikeModelRepository;
use App\Domain\Service\BikeModelValidator\BikeModelValidatorImpl;
use App\Domain\Service\BikeModelValidator\BikeValidationException;
use App\Tests\unit\Domain\Model\Bike\BikeBuilder;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class BikeBrandValidatorImplTest extends TestCase
{
    use ProphecyTrait;

    /** @test */
    public function should_not_validate_a_bike_with_an_invalid_brand(){
        $bikeModelRepository = $this->prophesize(BikeModelRepository::class);
        $bikeBrandValidatorImpl =  new BikeModelValidatorImpl($bikeModelRepository->reveal());
        $brand = 'anInvalidBrand';
        $aBike = BikeBuilder::aBike()
            ->withBrand(BikeBrand::createFromString($brand))
            ->build();
        $bikeModelRepository->findBrand(Argument::any())->willReturn(null);

        $this->expectException(BikeValidationException::class);
        $bikeBrandValidatorImpl->validateModel($aBike);
    }

    /** @test */
    public function should_not_validate_a_bike_with_an_invalid_model(){
        $bikeModelRepository = $this->prophesize(BikeModelRepository::class);
        $bikeBrandValidatorImpl =  new BikeModelValidatorImpl($bikeModelRepository->reveal());
        $brand = 'aValidBrand';
        $model = 'anInvalidModel';
        $aBike = BikeBuilder::aBike()
            ->withBrand(BikeBrand::createFromString($brand))
            ->withModel(BikeModel::createFromString($model))
            ->build();
        $bikeModelRepository->findBrand(Argument::any())->willReturn(BikeBrand::createFromString($brand));
        $bikeModelRepository->findModelForBrand(Argument::cetera())->willReturn(null);

        $this->expectException(BikeValidationException::class);
        $bikeBrandValidatorImpl->validateModel($aBike);
    }
}
