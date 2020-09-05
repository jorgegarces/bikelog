<?php

namespace App\Domain\Model\BikeBrand;

interface BikeBrandRepository
{
    public function searchBrand(string $brand): ?BikeBrand;
}
