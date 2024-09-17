<?php

namespace Modules\Ilocations\Repositories\Eloquent;

use Modules\Ilocations\Repositories\ProvinceRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentProvinceRepository extends EloquentCrudRepository implements ProvinceRepository
{
  /**
   * Filter names to replace
   * @var array
   */
  protected $replaceFilters = ['countryId'];

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
  protected $with = ['all' => [] ,'index' => ['translations'],'show' => []];

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
    if (isset($filter->country))
      $query->where("country_id", $filter->country);

    if (isset($filter->iso2)) {
      $query->whereIn("iso_2", (array)$filter->iso2);
    }

    if (isset($filter->countryCode)) {
      $code = $filter->countryCode;
      $query->whereHas("country", function ($q) use ($code) {
        $q->where('iso_2', $code);
      });
    }

    //New filter by search
    if (isset($filter->search)) {
      $query->where(function ($query) use ($filter) {
        $locale = $filter->locale ?? \App::getLocale();
        $query->whereRaw("ilocations__provinces.id IN (SELECT ipt.province_id FROM ilocations__province_translations AS ipt WHERE ipt.locale = '$locale' AND ipt.name LIKE '%$filter->search%')")
          ->orWhere('ilocations__provinces.id', 'like', '%' . $filter->search . '%')
          ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
          ->orWhere('created_at', 'like', '%' . $filter->search . '%');
      });
    }

    $availableCountries = json_decode(setting("ilocations::availableCountries", null, "[]"));
    /*=== SETTINGS ===*/
    if (!empty($availableCountries) && !isset($params->filter->indexAll)) {
      if (!isset($params->permissions['ilocations.provinces.manage']) || (!$params->permissions['ilocations.provinces.manage'])) {
        $query->whereHas("country", function ($query) use ($availableCountries) {
          $query->whereIn("ilocations__countries.iso_2", $availableCountries);
        });

      }
    }

    $availableProvinces = json_decode(setting("ilocations::availableProvinces", null, "[]"));
    /*=== SETTINGS ===*/
    if (!empty($availableProvinces) && !isset($params->filter->indexAll)) {
      if (!isset($params->permissions['ilocations.provinces.manage']) || (!$params->permissions['ilocations.provinces.manage'])) {

        $query->whereIn('ilocations__provinces.iso_2', $availableProvinces);

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

  public function findByIso2($iso2)
  {
    return $this->model->where('iso_2', $iso2)->first();
  }
  
}
