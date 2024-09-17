<?php

namespace Modules\Ilocations\Repositories;

use Modules\Core\Icrud\Repositories\BaseCrudRepository;

interface CityRepository extends BaseCrudRepository
{

    public function whereByCountry($id);
    
}
