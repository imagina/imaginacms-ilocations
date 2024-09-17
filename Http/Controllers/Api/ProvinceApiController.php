<?php

namespace Modules\Ilocations\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ilocations\Entities\Province;
use Modules\Ilocations\Repositories\ProvinceRepository;

class ProvinceApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Province $model, ProvinceRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
