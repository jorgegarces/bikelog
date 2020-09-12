<?php

namespace App\Tests\unit\Application\Service\Bike;

use App\Application\Service\Bike\SaveBikeUseCase;
use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeModel\BikeBrand;
use App\Domain\Model\Bike\BikeModel\BikeModel;
use App\Domain\Model\Bike\BikeRepository;
use App\Domain\Model\Bike\ValueObjects\BikeId;
use App\Domain\Model\Bike\ValueObjects\BikeValidationException;
use App\Domain\Model\Bike\ValueObjects\BikeYear;
use App\Domain\Service\BikeModelValidator\BikeModelValidator;
use App\Tests\unit\Domain\Model\Bike\BikeDTOBuilder;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class SaveBikeUseCaseTest extends TestCase
{
    use ProphecyTrait;

    private $bikeRepository;
    private $bikeBrandValidator;
    private $saveBikeUseCase;

    protected function setUp(): void
    {
        $this->bikeRepository = $this->prophesize(BikeRepository::class);
        $this->bikeBrandValidator = $this->prophesize(BikeModelValidator::class);
        $this->saveBikeUseCase = new SaveBikeUseCase(
            $this->bikeRepository->reveal(),
            $this->bikeBrandValidator->reveal()
        );
    }

    /** @test */
    public function should_send_request_to_save_a_new_bike_with_valid_bike_info()
    {
        $id = '5a6b3bf2-6459-4b44-8bfa-1c3838981348';
        $brand = 'aValidBrand';
        $model = 'aValidModel';
        $year = 2008;
        $saveBikeRequest = BikeDTOBuilder::aBike()
            ->withId($id)
            ->withBrand($brand)
            ->withModel($model)
            ->withYear($year)
            ->build();

        $this->saveBikeUseCase->addBike($saveBikeRequest);

        $this->bikeRepository->save(Argument::that(function (Bike $expectedBike) use ($id, $model, $brand, $year) {
            return $expectedBike->id()->equals(BikeId::createFromString($id))
                && $expectedBike->model()->equals(BikeModel::createFromString($model))
                && $expectedBike->brand()->equals(BikeBrand::createFromString($brand))
                && $expectedBike->year()->equals(BikeYear::createFromInt($year));
        }))->shouldHaveBeenCalled();
    }

    /** @test */
    public function should_not_save_a_bike_with_an_invalid_id()
    {
        $id = 'anInvalidId';
        $saveBikeRequest = BikeDTOBuilder::aBike()
            ->withId($id)
            ->build();

        $this->expectException(BikeValidationException::class);
        $this->saveBikeUseCase->addBike($saveBikeRequest);

        $this->bikeRepository->save(Argument::any())->shouldNotHaveBeenCalled();
    }

    /** @test */
    public function should_not_save_a_bike_with_an_invalid_year()
    {
        $year = 1959;
        $saveBikeRequest = BikeDTOBuilder::aBike()
            ->withYear($year)
            ->build();

        $this->expectException(BikeValidationException::class);
        $this->saveBikeUseCase->addBike($saveBikeRequest);

        $this->bikeRepository->save(Argument::any())->shouldNotHaveBeenCalled();
    }

    /** @test */
    public function should_not_save_a_bike_with_invalid_bike_model()
    {
        $model = 'anInvalidModel';
        $saveBikeRequest = BikeDTOBuilder::aBike()
            ->withModel($model)
            ->build();
        $this->bikeBrandValidator->validateModel(Argument::any())
            ->willThrow(BikeValidationException::class);

        $this->expectException(BikeValidationException::class);
        $this->saveBikeUseCase->addBike($saveBikeRequest);

        $this->bikeRepository->save(Argument::any())->shouldNotHaveBeenCalled();
    }
}
