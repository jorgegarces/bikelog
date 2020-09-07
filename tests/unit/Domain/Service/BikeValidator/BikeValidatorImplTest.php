<?php

namespace App\Tests\unit\Domain\Service\BikeValidator;

use App\Domain\Model\Bike\BikeId;
use App\Domain\Service\BikeValidator\BikeValidationException;
use App\Domain\Service\BikeValidator\BikeValidatorImpl;
use App\Tests\unit\Domain\Model\Bike\BikeBuilder;
use PHPUnit\Framework\TestCase;

class BikeValidatorImplTest extends TestCase
{
    private $bikeValidator;

    public function setUp(): void
    {
        $this->bikeValidator = new BikeValidatorImpl();
    }

    /** @test */
    public function should_not_validate_an_incorrect_id()
    {
        $anId = "anInvalidId";
        $aBike = BikeBuilder::aBike()
            ->withId(BikeId::createFromString($anId))
            ->build();

       $this->expectException(BikeValidationException::class);
       $this->expectExceptionMessage('Invalid Id');
       $this->bikeValidator->validateBike($aBike);
    }
}
