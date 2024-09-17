<?php

namespace Modules\Ilocations\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Neighborhood extends CrudModel
{
  use Translatable;

  protected $table = 'ilocations__neighborhoods';
  public $transformer = 'Modules\Ilocations\Transformers\NeighborhoodTransformer';
  public $repository = 'Modules\Ilocations\Repositories\NeighborhoodRepository';
  public $requestValidation = [
      'create' => 'Modules\Ilocations\Http\Requests\CreateNeighborhoodRequest',
      'update' => 'Modules\Ilocations\Http\Requests\UpdateNeighborhoodRequest',
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
 
  public $translatedAttributes = ["name"];
  protected $fillable = [
    "city_id",
    "country_id",
    "province_id",
    
  ];

  public function city()
  {
      return $this->belongsTo(City::class);
  }
  
  public function province()
  {
      return $this->belongsTo(Province::class);
  }

  public function country()
  {
      return $this->belongsTo(Country::class);
  }

  public function geozones()
  {
    return $this->morphToMany(Geozones::class, 'geozonable');
  }

  public function __call($method, $parameters)
  {
      #i: Convert array to dot notation
      $config = implode('.', ['asgard.ilocations.config.relations.neighborhood', $method]);

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
