<?php

namespace Modules\Ilocations\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ilocations\Entities\Polygon;
use Modules\Ilocations\Repositories\PolygonRepository;

class PolygonApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Polygon $model, PolygonRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
