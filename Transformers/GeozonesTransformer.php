<?php

namespace Modules\Ilocations\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class GeozonesTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
    return [
      'zonesToGeozone' => ZoneTransformer::collection($this->whenLoaded('zonesToGeozone'))
    ];
  }
}
