<?php

namespace Modules\Ilocations\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class CountryTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
    return [];
  }
}
