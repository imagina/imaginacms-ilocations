<?php

namespace Modules\Ilocations\Repositories\Cache;

use Modules\Ilocations\Repositories\GeozonesRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheGeozonesDecorator extends BaseCacheCrudDecorator implements GeozonesRepository
{
    public function __construct(GeozonesRepository $geozones)
    {
        parent::__construct();
        $this->entityName = 'ilocations.geozones';
        $this->repository = $geozones;
    }

    public function getAll()
    {
        return $this->remember(function () {
        return $this->repository->getAll();
        });
    }

}
