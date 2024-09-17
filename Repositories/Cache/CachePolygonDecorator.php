<?php

namespace Modules\Ilocations\Repositories\Cache;

use Modules\Ilocations\Repositories\PolygonRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CachePolygonDecorator extends BaseCacheCrudDecorator implements PolygonRepository
{
    public function __construct(PolygonRepository $polygon)
    {
        parent::__construct();
        $this->entityName = 'ilocations.polygons';
        $this->repository = $polygon;
    }
}
