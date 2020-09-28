<?php

namespace App\Infrastructure;

use App\Domain\Model\Bike\Bike;
use App\Domain\Model\Bike\BikeRepository;

class InMemoryBikeRepository implements BikeRepository
{
    private $bikes = [];

    public function save(Bike $bike): Bike
    {
        foreach ($this->bikes as $existingBike) {
            if ($existingBike['plateNumber'] == $bike->plateNumber()) {
                throw new BikeExistsException();
            }
        }

        $this->bikes[] = [
            'id' => $bike->id(),
            'plateNumber' => $bike->plateNumber(),
            'brand' => $bike->brand(),
            'model' => $bike->model(),
            'year' => $bike->year(),
        ];

        return $bike;
    }
}
