<?php

namespace Modules\Ilocations\Repositories\Eloquent;

use Modules\Ilocations\Repositories\GeozonesRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentGeozonesRepository extends EloquentCrudRepository implements GeozonesRepository
{
  /**
   * Filter names to replace
   * @var array
   */
  protected $replaceFilters = [];

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

    if (isset($filter->search) && !empty($filter->search)) {
      $query->where('name', 'like', "%{$filter->search}%");
    }

    /* Filter for address */
    if(isset($filter->address) && isset($filter->address->city) && isset($filter->address->province) && isset($filter->address->country)){

      $query->whereHas('cities', function ($query) use ($filter) {
        $query->where('ilocations__cities.id', $filter->address->city);
      });

      $query->orWhereHas('countries', function ($query) use ($filter) {
        $query->where('ilocations__countries.id', $filter->address->country);
      });

      $query->orWhereHas('provinces', function ($query) use ($filter) {
        $query->where('ilocations__provinces.id', $filter->address->province);
      });

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

  public function getAll(){
    return $this->model->orderBy('name','asc')->get();
  }

  /**
   * Method to create model
   *
   * @param $data
   * @return mixed
   */
  public function create($data)
  {
    //Event creating model
    $this->dispatchesEvents(['eventName' => 'creating', 'data' => $data]);

    // Call function before create it, and take all change from $data
    $this->beforeCreate($data);

    //Create model
    $model = $this->model->create($data);

    if ($model) {
      if(isset($data['zones_to_geozone'])){
          $model->zonesToGeozone()->createMany($data['zones_to_geozone']);
      }
    }

    // Default sync model relations
    $model = $this->defaultSyncModelRelations($model, $data);

    // Custom sync model relations
    $model = $this->syncModelRelations($model, $data);

    // Call function after create it, and take all change from $data and $model
    $this->afterCreate($model, $data);

    //Event created model
    $this->dispatchesEvents(['eventName' => 'created', 'data' => $data, 'model' => $model]);

    //Response
    return $model;
  }

  /**
   * Method to update model by criteria
   *
   * @param $criteria
   * @param $data
   * @param $params
   * @return mixed
   */
  public function updateBy($criteria, $data, $params = false)
  {
    //Event updating model
    $this->dispatchesEvents(['eventName' => 'updating', 'data' => $data, 'criteria' => $criteria]);

    //Instance Query
    $query = $this->model->query();

    //Check field name to criteria
    if (isset($params->filter->field)) $field = $params->filter->field;

    //get model and update
    $model = $query->where($field ?? 'id', $criteria)->first();
    if (isset($model)) {
      $this->beforeUpdate($data);
      //Update Model
      $model->update((array)$data);

      if ($model) {
        if(isset($data['zones_to_geozone'])) {
            $model->zonesToGeozone()->delete();
            $model->zonesToGeozone()->createMany($data['zones_to_geozone']);
        }
      }

      // Default Sync model relations
      $model = $this->defaultSyncModelRelations($model, $data);
      // Custom Sync model relations
      $model = $this->syncModelRelations($model, $data);
      // Call function after update it, and take all change from $data and $model
      $this->afterUpdate($model, $data);
      //Event updated model
      $this->dispatchesEvents([
        'eventName' => 'updated',
        'data' => $data,
        'criteria' => $criteria,
        'model' => $model
      ]);
    }

    //Response
    return $model;
  }

}
