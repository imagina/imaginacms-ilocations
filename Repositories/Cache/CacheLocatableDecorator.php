<?php

namespace Modules\Ilocations\Repositories\Cache;

use Modules\Ilocations\Repositories\LocatableRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheLocatableDecorator extends BaseCacheCrudDecorator implements LocatableRepository
{
    public function __construct(LocatableRepository $locatable)
    {
        parent::__construct();
        $this->entityName = 'ilocations.locatables';
        $this->repository = $locatable;
    }
}
