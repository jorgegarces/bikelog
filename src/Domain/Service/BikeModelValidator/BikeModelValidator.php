<?php

namespace App\Domain\Service\BikeModelValidator;

use App\Domain\Model\Bike\Bike;

interface BikeModelValidator
{
    public function validateModel(Bike $prospectBike);
}
