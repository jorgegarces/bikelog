<?php

namespace App\Domain\Service\BikeModelValidator;

use App\Domain\Model\Bike\Bike;

interface IBikeModelValidator
{
    public function validateModel(Bike $prospectBike);
}
