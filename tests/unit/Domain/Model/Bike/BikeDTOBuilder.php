<?php

namespace App\Tests\unit\Domain\Model\Bike;

use App\Domain\Model\Bike\BikeDTO;

class BikeDTOBuilder
{
    private $brand;
    private $model;
    private $year;

    private function __construct()
    {
        $this->brand = 'Honda';
        $this->model = 'Fireblade';
        $this->year = 2000;
    }

    public static function aBike(): self
    {
        return new self();
    }

    public function withBrand(string $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    public function withModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function withYear(int $year): self
    {
        $this->year = $year;
        return $this;
    }

    public function build(): BikeDTO
    {
        return new BikeDTO(
            $this->brand,
            $this->model,
            $this->year
        );
    }
}
