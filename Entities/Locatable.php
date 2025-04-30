<?php

namespace Modules\Ilocations\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

class Locatable extends CrudModel
{

  protected $table = 'ilocations__locatables';
  public $transformer = 'Modules\Ilocations\Transformers\LocatableTransformer';
  public $repository = 'Modules\Ilocations\Repositories\LocatableRepository';
  public $requestValidation = [
      'create' => 'Modules\Ilocations\Http\Requests\CreateLocatableRequest',
      'update' => 'Modules\Ilocations\Http\Requests\UpdateLocatableRequest',
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
  protected $fillable = [
    'entity_id',
    'entity_type',
    'city_id',
    'province_id',
    'country_id'
  ];

}
