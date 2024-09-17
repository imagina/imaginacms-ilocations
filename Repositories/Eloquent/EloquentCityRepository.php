<?php

namespace Modules\Ilocations\Repositories\Eloquent;

use Modules\Ilocations\Repositories\CityRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentCityRepository extends EloquentCrudRepository implements CityRepository
{
  /**
   * Filter names to replace
   * @var array
   */
  protected $replaceFilters = ['provinceId'];

  /**
   * Relation names to replace
   * @var array
   */
  protected $replaceSyncModelRelations = [];

  /**
   * Attribute to define default relations
   * all apply to index and show
   * index apply in the getItemsBy
   * show apply in the getItem
   * @var array
   */
  protected $with = [/*all => [] ,index => [],show => []*/];

  /**
   * Filter query
   *
   * @param $query
   * @param $filter
   * @param $params
   * @return mixed
   */
  public function filterQuery($query, $filter, $params)
  {

    /**
     * Note: Add filter name to replaceFilters attribute before replace it
     *
     * Example filter Query
     * if (isset($filter->status)) $query->where('status', $filter->status);
     *
     */
    if (isset($filter->province))
      $query->where("province_id", $filter->province);

     //add filter by search
    if (isset($filter->search)) {
      //find search in columns
      $query->where(function ($query) use ($filter) {
        $query->whereHas('translations', function ($q) use ($filter) {
          $q->where('name', 'like', '%' . $filter->search . '%');
        })->orWhere('id', 'like', '%' . $filter->search . '%');
      });
    }

    $availableCountries = json_decode(setting("ilocations::availableCountries", null, "[]"));
    /*=== SETTINGS ===*/
    if (!empty($availableCountries) && !isset($params->filter->indexAll)) {
      if (!isset($params->permissions['ilocations.cities.manage']) || (!$params->permissions['ilocations.cities.manage'])) {
        $query->whereHas("country", function ($query) use ($availableCountries){
          $query->whereIn("ilocations__countries.iso_2",$availableCountries);
        });

      }
    }

    $availableProvinces = json_decode(setting("ilocations::availableProvinces", null, "[]"));
    /*=== SETTINGS ===*/
    if (!empty($availableProvinces) && !isset($params->filter->indexAll)) {
      if (!isset($params->permissions['ilocations.cities.manage']) || (!$params->permissions['ilocations.cities.manage'])) {
        $query->whereHas("province", function ($query) use ($availableProvinces){
          $query->whereIn("ilocations__provinces.iso_2",$availableProvinces);
        });

      }
    }

    $availableCities = json_decode(setting("ilocations::availableCities", null, "[]"));
    /*=== SETTINGS ===*/
    if (!empty($availableCities) && !isset($params->filter->indexAll)) {
      if (!isset($params->permissions['ilocations.cities.manage']) || (!$params->permissions['ilocations.cities.manage'])) {

        $query->whereIn('ilocations__cities.id', $availableCities);

      }
    }

    //Response
    return $query;
  }

  /**
   * Method to sync Model Relations
   *
   * @param $model ,$data
   * @return $model
   */
  public function syncModelRelations($model, $data)
  {
    //Get model relations data from attribute of model
    $modelRelationsData = ($model->modelRelations ?? []);

    /**
     * Note: Add relation name to replaceSyncModelRelations attribute before replace it
     *
     * Example to sync relations
     * if (array_key_exists(<relationName>, $data)){
     *    $model->setRelation(<relationName>, $model-><relationName>()->sync($data[<relationName>]));
     * }
     *
     */

    //Response
    return $model;
  }

  public function whereByCountry($id)
  {
    return $this->model->where('country_id', $id)->get();
  }
  
}
