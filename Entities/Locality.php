<?php

namespace Modules\Ilocations\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Locality extends CrudModel
{
  use Translatable;

  protected $table = 'ilocations__localities';
  public $transformer = 'Modules\Ilocations\Transformers\LocalityTransformer';
  public $repository = 'Modules\Ilocations\Repositories\LocalityRepository';
  public $requestValidation = [
      'create' => 'Modules\Ilocations\Http\Requests\CreateLocalityRequest',
      'update' => 'Modules\Ilocations\Http\Requests\UpdateLocalityRequest',
    ];
  //Instance external/internal events to dispatch with extraData
  public $dispatchesEventsWithBindings = [
    //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
    'created' => [],
    'creating' => [],
    'updated' => [],
    'updating' => [],
    'deleting' => [],
    'deleted' => []
  ];
  public $translatedAttributes = [
    'name'
  ];
  protected $fillable = [
    'code',
    'province_id',
    'country_id',
    "city_id"
  ];
}
