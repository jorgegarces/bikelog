<?php

namespace App\Domain\Service\BikeInfoValidator;

use App\Domain\Model\Bike\BikeDTO;

interface BikeInfoValidator
{
    public function checkBikeInfo(BikeDTO $bikeInfo);
}
