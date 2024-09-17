<?php

namespace Modules\Ilocations\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ilocations\Entities\Neighborhood;
use Modules\Ilocations\Repositories\NeighborhoodRepository;

class NeighborhoodApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Neighborhood $model, NeighborhoodRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
