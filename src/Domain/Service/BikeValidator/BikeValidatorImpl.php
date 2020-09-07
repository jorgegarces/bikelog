<?php

namespace App\Domain\Service\BikeValidator;

use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeId;

class BikeValidatorImpl implements BikeValidator
{
    const UUID_PATTERN = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';

    public function validateBike(Bike $prospectBike)
    {
        $this->validateId($prospectBike->id());
    }

    private function validateId(BikeId $id)
    {
        $bikeId = $id->getId();
        if ((preg_match(self::UUID_PATTERN, $bikeId) !== 1)) {
            throw new BikeValidationException('Invalid Id');
        }
    }
}
