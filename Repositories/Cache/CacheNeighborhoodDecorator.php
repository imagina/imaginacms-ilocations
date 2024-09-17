<?php

namespace Modules\Ilocations\Repositories\Cache;

use Modules\Ilocations\Repositories\NeighborhoodRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheNeighborhoodDecorator extends BaseCacheCrudDecorator implements NeighborhoodRepository
{
    public function __construct(NeighborhoodRepository $neighborhood)
    {
        parent::__construct();
        $this->entityName = 'ilocations.neighborhoods';
        $this->repository = $neighborhood;
    }
}
