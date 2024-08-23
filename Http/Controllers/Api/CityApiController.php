<?php

namespace Modules\Ilocations\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ilocations\Entities\City;
use Modules\Ilocations\Repositories\CityRepository;

class CityApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(City $model, CityRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
