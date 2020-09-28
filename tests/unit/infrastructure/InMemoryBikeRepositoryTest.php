<?php

namespace App\Tests\unit\infrastructure;

use App\Domain\Model\Bike\ValueObjects\BikeId;
use App\Domain\Model\Bike\ValueObjects\BikePlateNumber;
use App\Infrastructure\BikeExistsException;
use App\Infrastructure\InMemoryBikeRepository;
use App\Tests\unit\Domain\Model\Bike\BikeBuilder;
use PHPUnit\Framework\TestCase;

class InMemoryBikeRepositoryTest extends TestCase
{
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new InMemoryBikeRepository();
    }

    /** @test */
    public function should_save_a_bike(){
        $aBike = BikeBuilder::aBike()->build();;

        $expectedBike = $this->repository->save($aBike);
        self::assertEquals($expectedBike, $aBike);
    }

    /** @test */
    public function should_save_multiple_bikes(){
        $aBike = BikeBuilder::aBike()
            ->withId(BikeId::createFromString('a7abc694-4d8b-4644-b5df-bf4dd00dc7ba'))
            ->withPlateNumber(BikePlateNumber::createFromString('0000AAA'))
            ->build();
        $anotherBike = BikeBuilder::aBike()
            ->withId(BikeId::createFromString('567c452c-28bf-4cec-9f9b-cce08a1f34b7'))
            ->withPlateNumber(BikePlateNumber::createFromString('0000BBB'))
            ->build();
        $this->repository->save($aBike);

        $response = $this->repository->save($anotherBike);

        self::assertEquals($response, $anotherBike);
    }

    /** @test */
    public function should_not_save_multiple_bikes_with_the_same_license_plate(){
        $aBike = BikeBuilder::aBike()
            ->withId(BikeId::createFromString('a7abc694-4d8b-4644-b5df-bf4dd00dc7ba'))
            ->withPlateNumber(BikePlateNumber::createFromString('0000AAB'))
            ->build();
        $anotherBike = BikeBuilder::aBike()
            ->withId(BikeId::createFromString('567c452c-28bf-4cec-9f9b-cce08a1f34b7'))
            ->withPlateNumber(BikePlateNumber::createFromString('0000AAB'))
            ->build();
        $this->repository->save($aBike);

        $this->expectException(BikeExistsException::class);
        $this->repository->save($anotherBike);
    }
}
