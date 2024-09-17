<?php

namespace Modules\Ilocations\Repositories\Cache;

use Modules\Ilocations\Repositories\CountryRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCountryDecorator extends BaseCacheCrudDecorator implements CountryRepository
{
    public function __construct(CountryRepository $country)
    {
        parent::__construct();
        $this->entityName = 'ilocations.countries';
        $this->repository = $country;
    }

    public function findByIso2($iso2)
    {
        return $this->remember(function () use ($iso2) {
            return $this->repository->findByIso2($iso2);
        });
    }
}
