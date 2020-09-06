<?php

namespace App\Domain\Model\Bike;

interface BikeRepository
{
    public function save(Bike $bike): Bike;
}
