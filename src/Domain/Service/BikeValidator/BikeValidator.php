<?php

namespace App\Domain\Service\BikeValidator;

use App\Domain\Model\Bike\Bike;

interface BikeValidator
{
    public function validateBike(Bike $prospectBike);
}
