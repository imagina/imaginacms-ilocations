<?php

namespace Modules\Ilocations\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ilocations\Entities\Geozones;
use Modules\Ilocations\Repositories\GeozonesRepository;

class GeozonesApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Geozones $model, GeozonesRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
