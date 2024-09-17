<?php

namespace Modules\Ilocations\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

class Geozones extends CrudModel
{
  
  protected $table = 'ilocations__geozones';
  public $transformer = 'Modules\Ilocations\Transformers\GeozonesTransformer';
  public $repository = 'Modules\Ilocations\Repositories\GeozonesRepository';
  public $requestValidation = [
      'create' => 'Modules\Ilocations\Http\Requests\CreateGeozonesRequest',
      'update' => 'Modules\Ilocations\Http\Requests\UpdateGeozonesRequest',
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
    'name',
    'description'
  ];

  public function zonesToGeoZone(){
      return $this->hasMany(GeozonesCountries::class,'geozone_id');
  }

  public function __call($method, $parameters)
  {
      #i: Convert array to dot notation
      $config = implode('.', ['asgard.ilocations.config.relations.geozones', $method]);

      #i: Relation method resolver
      if (config()->has($config)) {
          $function = config()->get($config);
          $bound = $function->bindTo($this);

          return $bound();
      }

      #i: No relation found, return the call to parent (Eloquent) to handle it.
      return parent::__call($method, $parameters);
  }

  

}
