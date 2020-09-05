<?php

namespace App\Tests\unit\Application\Service\Bike;

use App\Application\Service\Bike\SaveBikeUseCase;
use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeModel;
use App\Domain\Model\Bike\BikeRepository;
use App\Domain\Model\BikeBrand\BikeBrand;
use App\Domain\Model\BikeBrand\BikeInfoRepository;
use App\Tests\unit\Domain\Model\Bike\BikeDTOBuilder;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class SaveBikeUseCaseTest extends TestCase
{
    use ProphecyTrait;

    private $bikeRepository;
    private $bikeInfoRepository;
    private $saveBikeUseCase;

    protected function setUp(): void
    {
        $this->bikeRepository = $this->prophesize(BikeRepository::class);
        $this->bikeInfoRepository = $this->prophesize(BikeInfoRepository::class);
        $this->saveBikeUseCase = new SaveBikeUseCase(
            $this->bikeRepository->reveal(),
            $this->bikeInfoRepository->reveal()
        );
    }

    /** @test */
    public function should_send_request_to_save_a_bike_with_a_valid_model_for_a_valid_brand()
    {
        $brand = 'aValidBrand';
        $model = 'aValidModel';
        $saveBikeRequest = BikeDTOBuilder::aBike()
            ->withBrand($brand)
            ->withModel($model)
            ->build();
        $this->bikeInfoRepository->findBrand(Argument::any())->willReturn(BikeBrand::createFromString(Argument::any()));
        $this->bikeInfoRepository->findModelForBrand(Argument::cetera())->willReturn(BikeModel::createFromString(Argument::any()));

        $this->saveBikeUseCase->addBike($saveBikeRequest);

        $this->bikeRepository->save(Argument::that(function (Bike $expectedBike) use ($model) {
            return $expectedBike->model()->equals(BikeModel::createFromString($model));
        }))->shouldHaveBeenCalled();
    }

    /** @test */
    public function should_not_save_a_bike_with_an_invalid_brand()
    {
        $brand = 'anInvalidBrand';
        $saveBikeRequest = BikeDTOBuilder::aBike()
            ->withBrand($brand)
            ->build();
        $this->bikeInfoRepository->findBrand(Argument::any())->willReturn(null);

        $this->expectException(InvalidArgumentException::class);
        $this->saveBikeUseCase->addBike($saveBikeRequest);

        $this->bikeRepository->save(Argument::any())->shouldNotHaveBeenCalled();
    }

    /** @test */
    public function should_not_save_a_bike_with_an_invalid_model()
    {
        $model = 'anInvalidModel';
        $saveBikeRequest = BikeDTOBuilder::aBike()
            ->withModel($model)
            ->build();
        $this->bikeInfoRepository->findBrand(Argument::any())->willReturn(BikeBrand::createFromString(Argument::any()));
        $this->bikeInfoRepository->findModelForBrand(Argument::cetera())->willReturn(null);

        $this->expectException(InvalidArgumentException::class);
        $this->saveBikeUseCase->addBike($saveBikeRequest);

        $this->bikeRepository->save(Argument::any())->shouldNotHaveBeenCalled();
    }

    /** @test */
    public function should_send_request_to_save_a_bike_with_year(){
        $year = 2008;
        $saveBikeRequest = BikeDTOBuilder::aBike()
            ->withYear($year)
            ->build();
        $this->bikeInfoRepository->findBrand(Argument::any())->willReturn(BikeBrand::createFromString(Argument::any()));
        $this->bikeInfoRepository->findModelForBrand(Argument::cetera())->willReturn(BikeModel::createFromString(Argument::any()));

        $this->saveBikeUseCase->addBike($saveBikeRequest);

        $this->bikeRepository->save(Argument::that(function (Bike $expectedBike) use ($year) {
            return $expectedBike->year() === $year;
        }))->shouldHaveBeenCalled();
    }
}
