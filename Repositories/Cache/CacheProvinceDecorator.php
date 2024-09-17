<?php

namespace Modules\Ilocations\Repositories\Cache;

use Modules\Ilocations\Repositories\ProvinceRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheProvinceDecorator extends BaseCacheCrudDecorator implements ProvinceRepository
{
    public function __construct(ProvinceRepository $province)
    {
        parent::__construct();
        $this->entityName = 'ilocations.provinces';
        $this->repository = $province;
    }

    public function findByIso2($iso2)
    {
        return $this->remember(function () use ($iso2) {
            return $this->repository->findByIso2($iso2);
        });
    }
}
