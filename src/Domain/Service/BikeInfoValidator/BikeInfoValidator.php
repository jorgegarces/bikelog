<?php

namespace App\Domain\Service\BikeInfoValidator;

use App\Domain\Model\Bike\BikeModel;
use App\Domain\Model\BikeBrand\BikeBrand;

interface BikeInfoValidator
{
    public function checkBikeInfo(BikeBrand $bikeBrand, BikeModel $bikeModel);
}
