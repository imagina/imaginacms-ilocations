<?php

namespace Modules\Ilocations\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Country extends CrudModel
{
  use Translatable;

  protected $table = 'ilocations__countries';
  public $transformer = 'Modules\Ilocations\Transformers\CountryTransformer';
  public $repository = 'Modules\Ilocations\Repositories\CountryRepository';
  public $requestValidation = [
      'create' => 'Modules\Ilocations\Http\Requests\CreateCountryRequest',
      'update' => 'Modules\Ilocations\Http\Requests\UpdateCountryRequest',
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
    'full_name'
  ];
  protected $fillable = [
    'currency',
    'currency_symbol',
    'currency_code',
    'currency_sub_unit',
    'region_code',
    'sub_region_code',
    'country_code',
    'iso_2',
    'iso_3',
    'calling_code',
    'status'
  ];

  public function provinces()
  {
    return $this->hasMany(Province::class);
  }

  public function children()
  {
    return $this->hasMany(Province::class)->with("children");
  }

  public function cities()
  {
    return $this->hasMany(City::class);
  }
  
  public function getNameAttribute(){
    
    $currentTranslations = $this->getTranslation(locale());
    
    if (empty($currentTranslations) || empty($currentTranslations->toArray()["name"])) {
      
      $model = $this->getTranslation(\LaravelLocalization::getDefaultLocale());
  
      if(empty($model)) return "";
      return $model->toArray()["name"] ?? "";
    }
    
    return $currentTranslations->toArray()["name"];
    
  }

  public function geozones()
  {
    return $this->morphToMany(Geozones::class, 'geozonable', 'ilocations__geozonables', 'geozone_id');
  }

  public function getFlagUrlAttribute()
  {

    //Default
    $url = url('modules/ilocations/img/countries/flags/default.jpg');
    //Format to with Imgs
    $fileName = strtolower($this->iso_2).".svg";
    
    //Validaiton Img
    $imgPath = public_path('/modules/ilocations/img/countries/flags/'.$fileName);
    if(file_exists($imgPath)) $url = url('/modules/ilocations/img/countries/flags/'.$fileName);

    return $url;

  }

  public function getIcoUrlAttribute()
  {

    //Default
    $url = url('modules/ilocations/img/countries/icons/default.jpg');
    //Format to with Imgs
    $fileName = strtolower($this->iso_2).".svg";
    
    //Validaiton Img
    $imgPath = public_path('/modules/ilocations/img/countries/icons/'.$fileName);
    if(file_exists($imgPath)) $url = url('/modules/ilocations/img/countries/icons/'.$fileName);

    return $url;

  }

  public function __call($method, $parameters)
  {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.ilocations.config.relations.country', $method]);

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
