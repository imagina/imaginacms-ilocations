<?php

namespace Modules\Ilocations\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ilocations\Entities\Country;
use Modules\Ilocations\Repositories\CountryRepository;

class CountryApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Country $model, CountryRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
