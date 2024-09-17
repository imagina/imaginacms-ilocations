<?php

namespace Modules\Ilocations\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Polygon extends CrudModel
{
  use Translatable;

  protected $table = 'ilocations__polygons';
  public $transformer = 'Modules\Ilocations\Transformers\PolygonTransformer';
  public $repository = 'Modules\Ilocations\Repositories\PolygonRepository';
  public $requestValidation = [
      'create' => 'Modules\Ilocations\Http\Requests\CreatePolygonRequest',
      'update' => 'Modules\Ilocations\Http\Requests\UpdatePolygonRequest',
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
    'name',
    'description'
  ];

  protected $fillable = [
    'points',
    'options',
  ];

  protected $casts = [
    'options' => 'array',
    'points' => 'array',
  ];

  public function geozones()
  {
    return $this->morphToMany(Geozones::class, 'geozonable');
  }

  public function __call($method, $parameters)
  {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.ilocations.config.relations.polygono', $method]);

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
