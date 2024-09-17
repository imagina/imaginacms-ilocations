<?php

namespace Modules\Ilocations\Repositories;

use Modules\Core\Icrud\Repositories\BaseCrudRepository;

interface GeozonesRepository extends BaseCrudRepository
{
    public function getAll();
}
