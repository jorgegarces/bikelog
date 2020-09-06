<?php

namespace App\Tests\unit\Application\Service\Bike;

use App\Application\Service\Bike\SaveBikeUseCase;
use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeModel;
use App\Domain\Model\Bike\BikeRepository;
use App\Domain\Model\Bike\BikeYear;
use App\Domain\Model\BikeBrand\BikeBrand;
use App\Domain\Service\BikeInfoValidator\BikeInfoException;
use App\Domain\Service\BikeInfoValidator\BikeInfoValidator;
use App\Tests\unit\Domain\Model\Bike\BikeDTOBuilder;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class SaveBikeUseCaseTest extends TestCase
{
    use ProphecyTrait;

    private $bikeRepository;
    private $saveBikeUseCase;
    private $bikeInfoValidator;

    protected function setUp(): void
    {
        $this->bikeRepository = $this->prophesize(BikeRepository::class);
        $this->bikeInfoValidator = $this->prophesize(BikeInfoValidator::class);
        $this->saveBikeUseCase = new SaveBikeUseCase(
            $this->bikeRepository->reveal(),
            $this->bikeInfoValidator->reveal()
        );
    }

    /** @test */
    public function should_send_request_to_save_a_new_bike_with_valid_bike_info()
    {
        $brand = 'aValidBrand';
        $model = 'aValidModel';
        $year = 2008;
        $saveBikeRequest = BikeDTOBuilder::aBike()
            ->withBrand($brand)
            ->withModel($model)
            ->withYear($year)
            ->build();

        $this->saveBikeUseCase->addBike($saveBikeRequest);

        $this->bikeRepository->save(Argument::that(function (Bike $expectedBike) use ($model, $brand, $year) {
            return $expectedBike->model()->equals(BikeModel::createFromString($model))
                && $expectedBike->brand()->equals(BikeBrand::createFromString($brand))
                && $expectedBike->year()->equals(BikeYear::createFromInt($year));

        }))->shouldHaveBeenCalled();
    }

   /** @test */
   public function should_not_save_a_bike_with_invalid_bike_info(){
       $saveBikeRequest = BikeDTOBuilder::aBike()
           ->build();
       $this->bikeInfoValidator->checkBikeInfo(Argument::any())->willThrow(BikeInfoException::class);

       $this->expectException(BikeInfoException::class);
       $this->saveBikeUseCase->addBike($saveBikeRequest);

       $this->bikeRepository->save(Argument::any())->shouldNotHaveBeenCalled();
   }
}
