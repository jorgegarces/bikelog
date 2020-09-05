<?php

namespace App\Domain\Model\BikeBrand;

use App\Domain\Model\Bike\BikeBrand;

interface BikeBrandRepository
{
    public function searchBrand(string $brand): BikeBrand;
}
