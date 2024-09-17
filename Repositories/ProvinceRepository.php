<?php

namespace Modules\Ilocations\Repositories;

use Modules\Core\Icrud\Repositories\BaseCrudRepository;

interface ProvinceRepository extends BaseCrudRepository
{
    public function findByIso2($iso2);
}
