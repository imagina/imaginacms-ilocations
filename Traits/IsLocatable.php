<?php

namespace Modules\Ilocations\Traits;

trait IsLocatable
{
  /**
   * Boot trait method
   */
  public static function bootIsLocatable()
  {
    //Listen event after create model
    static::createdWithBindings(function ($model) {
      //Sync schedules
      $model->syncLocatable($model->getEventBindings('createdWithBindings'));
    });
    //Listen event after update model
    static::updatedWithBindings(function ($model) {
      //Sync Schedules
      $model->syncLocatable($model->getEventBindings('updatedWithBindings'));
    });
    //Listen event after delete model
    static::deleted(function ($model) {
      $model->locatable()->forceDelete();
    });
  }

  public function syncLocatable($params)
  {
    $cityId = $params['data']['locatable']['city_id'] ?? null;
    $countryId = $params['data']['locatable']['country_id'] ?? null;
    $provinceId = $params['data']['locatable']['province_id'] ?? null;

    if ($cityId || $countryId || $provinceId) {
      $locatableRepository = app('Modules\Ilocations\Repositories\LocatableRepository');
      $locatableRepository->updateOrCreate([
        'entity_type' => get_class($this),
        'entity_id' => $this->id,
      ], [
        'city_id' => $cityId,
        'country_id' => $countryId,
        'province_id' => $provinceId,
      ]);
    }
  }

  /**
   * Return the Locatable resource
   */
  public function Locatable()
  {
    return $this->morphOne("Modules\Ilocations\Entities\Locatable", 'entity');
  }

  /**
   * magic method to return the Location from the Locatable
   */
  public function getLocatableInfoAttribute()
  {
    if ($this->relationLoaded('locatable')) {
      return [
       'cityId' => $this->locatable->city_id ?? null,
       'provinceId' => $this->locatable->province_id ?? null,
       'countryId' => $this->locatable->country_id ?? null
      ];
    } else {
      return null;
    }
  }
}
