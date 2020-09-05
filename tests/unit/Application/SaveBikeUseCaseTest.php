<?php

namespace App\Tests\unit\Application;

use App\Application\Service\Bike\SaveBikeUseCase;
use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeRepository;
use App\Domain\Model\BikeBrand\BikeBrand;
use App\Domain\Model\BikeBrand\BikeBrandRepository;
use App\Tests\unit\Domain\Model\Bike\BikeDTOBuilder;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class SaveBikeUseCaseTest extends TestCase
{
    use ProphecyTrait;

    private $bikeRepository;
    private $bikeBrandRepository;
    private $saveBikeUseCase;

    protected function setUp(): void
    {
        $this->bikeRepository = $this->prophesize(BikeRepository::class);
        $this->bikeBrandRepository = $this->prophesize(BikeBrandRepository::class);
        $this->saveBikeUseCase = new SaveBikeUseCase(
            $this->bikeRepository->reveal(),
            $this->bikeBrandRepository->reveal()
        );
    }

    /** @test */
    public function should_send_request_to_save_a_bike_with_a_valid_brand()
    {
        $validBrand = 'aValidBrand';
        $saveBikeRequest = BikeDTOBuilder::aBike()
            ->withBrand($validBrand)
            ->build();
        $this->bikeBrandRepository->searchBrand($validBrand)->willReturn(BikeBrand::createFromString($validBrand));

        $this->saveBikeUseCase->addBike($saveBikeRequest);

        $this->bikeRepository->save(Argument::that(function (Bike $expectedBike) use ($validBrand) {
            return $expectedBike->brand()->equals(BikeBrand::createFromString($validBrand));
        }))->shouldHaveBeenCalled();
    }

    /** @test */
    public function should_not_save_a_bike_with_an_invalid_brand()
    {
        $invalidBrand = 'anInvalidBrand';
        $saveBikeRequest = BikeDTOBuilder::aBike()
            ->withBrand($invalidBrand)
            ->build();
        $this->bikeBrandRepository->searchBrand($invalidBrand)->willReturn(null);

        $this->expectException(InvalidArgumentException::class);
        $this->saveBikeUseCase->addBike($saveBikeRequest);

        $this->bikeRepository->save(Argument::any())->shouldNotHaveBeenCalled();
    }
}
