<?php

namespace App\Tests\unit\Application\Service\Bike;

use App\Application\Service\Bike\SaveBikeUseCase;
use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeId;
use App\Domain\Model\Bike\BikeRepository;
use App\Domain\Model\BikeInfo\BikeBrand;
use App\Domain\Model\BikeInfo\BikeModel;
use App\Domain\Model\BikeInfo\BikeYear;
use App\Domain\Service\BikeValidator\BikeValidationException;
use App\Domain\Service\BikeValidator\BikeValidator;
use App\Tests\unit\Domain\Model\Bike\BikeDTOBuilder;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class SaveBikeUseCaseTest extends TestCase
{
    use ProphecyTrait;

    private $bikeRepository;
    private $bikeValidator;
    private $saveBikeUseCase;

    protected function setUp(): void
    {
        $this->bikeRepository = $this->prophesize(BikeRepository::class);
        $this->bikeValidator = $this->prophesize(BikeValidator::class);
        $this->saveBikeUseCase = new SaveBikeUseCase(
            $this->bikeRepository->reveal(),
            $this->bikeValidator->reveal()
        );
    }

    /** @test */
    public function should_send_request_to_save_a_new_bike_with_valid_bike_info()
    {
        $id = 'aValidId';
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
   public function should_not_save_a_bike_with_invalid_bike_info(){
       $model = 'anInvalidModel';
       $saveBikeRequest = BikeDTOBuilder::aBike()
           ->withModel($model)
           ->build();
       $this->bikeValidator->validateBike(Argument::any())->willThrow(BikeValidationException::class);

       $this->expectException(BikeValidationException::class);
       $this->saveBikeUseCase->addBike($saveBikeRequest);

       $this->bikeRepository->save(Argument::any())->shouldNotHaveBeenCalled();
   }
}
