<?php

namespace Modules\Ilocations\Repositories;

use Modules\Core\Icrud\Repositories\BaseCrudRepository;

interface CountryRepository extends BaseCrudRepository
{
    public function findByIso2($iso2);
}
