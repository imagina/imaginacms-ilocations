<?php

namespace Modules\Ilocations\Repositories\Cache;

use Modules\Ilocations\Repositories\CityRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCityDecorator extends BaseCacheCrudDecorator implements CityRepository
{
    public function __construct(CityRepository $city)
    {
        parent::__construct();
        $this->entityName = 'ilocations.cities';
        $this->repository = $city;
    }

    public function whereByCountry($id)
    {

        return $this->remember(function () use ($id) {
            return $this->repository->whereByCountry($id);
        });
    }
}
