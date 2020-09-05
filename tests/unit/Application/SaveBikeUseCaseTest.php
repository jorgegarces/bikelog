<?php

namespace App\Tests\unit\Application;

use App\Application\Service\Bike\SaveBikeUseCase;
use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeBrand;
use App\Domain\Model\Bike\BikeRepository;
use App\Tests\unit\Domain\Model\Bike\BikeDTOBuilder;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Log\InvalidArgumentException;

class SaveBikeUseCaseTest extends TestCase
{
    use ProphecyTrait;

    private $bikeRepository;
    private $saveBikeUseCase;

    protected function setUp(): void
    {
        $this->bikeRepository = $this->prophesize(BikeRepository::class);
        $this->saveBikeUseCase = new SaveBikeUseCase(
            $this->bikeRepository->reveal()
        );
    }

    /** @test */
    public function should_send_request_to_save_a_bike_with_brand()
    {
        $brand = 'Yamaha';
        $saveBikeRequest = BikeDTOBuilder::aBike()
            ->withBrand($brand)
            ->build();

        $this->saveBikeUseCase->addBike($saveBikeRequest);

        $this->bikeRepository->save(Argument::that(function (Bike $expectedBike) use ($brand) {
            return $expectedBike->brand()->equals(BikeBrand::createFromString($brand));
        }))->shouldHaveBeenCalled();
    }

    /** @test */
    public function should_not_send_request_to_save_a_bike_with_invalid_brand()
    {
        $brand = 'Yamaho';
        $saveBikeRequest = BikeDTOBuilder::aBike()
            ->withBrand($brand)
            ->build();

        $this->expectException(InvalidArgumentException::class);
        $this->saveBikeUseCase->addBike($saveBikeRequest);

        $this->bikeRepository->save(Argument::any())->shouldNotHaveBeenCalled();
    }
}
