<?php

use Illuminate\Routing\Router;

$router->group(['prefix' =>'/v2/ilocations'], function (Router $router) {

    $router->apiCrud([
      'module' => 'ilocations',
      'prefix' => 'cities',
      'controller' => 'CityApiController',
      'middleware' => ['index' => [], 'show' => []]
      // 'customRoutes' => [ // Include custom routes if needed
      //  [
      //    'method' => 'post', // get,post,put....
      //    'path' => '/some-path', // Route Path
      //    'uses' => 'ControllerMethodName', //Name of the controller method to use
      //    'middleware' => [] // if not set up middleware, auth:api will be the default
      //  ]
      // ]
    ]);

    $router->apiCrud([
      'module' => 'ilocations',
      'prefix' => 'countries',
      'controller' => 'CountryApiController',
      'middleware' => ['index' => [], 'show' => []]
      // 'customRoutes' => [ // Include custom routes if needed
      //  [
      //    'method' => 'post', // get,post,put....
      //    'path' => '/some-path', // Route Path
      //    'uses' => 'ControllerMethodName', //Name of the controller method to use
      //    'middleware' => [] // if not set up middleware, auth:api will be the default
      //  ]
      // ]
    ]);

    $router->apiCrud([
      'module' => 'ilocations',
      'prefix' => 'geozones',
      'controller' => 'GeozonesApiController',
      'middleware' => ['index' => [], 'show' => []]
      // 'customRoutes' => [ // Include custom routes if needed
      //  [
      //    'method' => 'post', // get,post,put....
      //    'path' => '/some-path', // Route Path
      //    'uses' => 'ControllerMethodName', //Name of the controller method to use
      //    'middleware' => [] // if not set up middleware, auth:api will be the default
      //  ]
      // ]
    ]);

    $router->apiCrud([
      'module' => 'ilocations',
      'prefix' => 'localities',
      'controller' => 'LocalityApiController',
      'middleware' => ['index' => [], 'show' => []]
      // 'customRoutes' => [ // Include custom routes if needed
      //  [
      //    'method' => 'post', // get,post,put....
      //    'path' => '/some-path', // Route Path
      //    'uses' => 'ControllerMethodName', //Name of the controller method to use
      //    'middleware' => [] // if not set up middleware, auth:api will be the default
      //  ]
      // ]
    ]);

    $router->apiCrud([
      'module' => 'ilocations',
      'prefix' => 'neighborhoods',
      'controller' => 'NeighborhoodApiController',
      'middleware' => ['index' => [], 'show' => []]
      // 'customRoutes' => [ // Include custom routes if needed
      //  [
      //    'method' => 'post', // get,post,put....
      //    'path' => '/some-path', // Route Path
      //    'uses' => 'ControllerMethodName', //Name of the controller method to use
      //    'middleware' => [] // if not set up middleware, auth:api will be the default
      //  ]
      // ]
    ]);

    $router->apiCrud([
      'module' => 'ilocations',
      'prefix' => 'polygons',
      'controller' => 'PolygonApiController',
      'middleware' => ['index' => [], 'show' => []]
      // 'customRoutes' => [ // Include custom routes if needed
      //  [
      //    'method' => 'post', // get,post,put....
      //    'path' => '/some-path', // Route Path
      //    'uses' => 'ControllerMethodName', //Name of the controller method to use
      //    'middleware' => [] // if not set up middleware, auth:api will be the default
      //  ]
      // ]
    ]);

    $router->apiCrud([
      'module' => 'ilocations',
      'prefix' => 'provinces',
      'controller' => 'ProvinceApiController',
      'middleware' => ['index' => [], 'show' => []]
      // 'customRoutes' => [ // Include custom routes if needed
      //  [
      //    'method' => 'post', // get,post,put....
      //    'path' => '/some-path', // Route Path
      //    'uses' => 'ControllerMethodName', //Name of the controller method to use
      //    'middleware' => [] // if not set up middleware, auth:api will be the default
      //  ]
      // ]
    ]);
// append


});

$router->group(['prefix' => '/ilocations'], function (Router $router) {

  $router->get('allfullcountries', [
    'as' => 'ilocation.api.get.allfullcountries',
    'uses' => 'CountryController@allFullCountries',
  ]);

  $router->get('allmincountries', [
    'as' => 'ilocation.api.get.allmincountries',
    'uses' => 'CountryController@allMinCountries',
  ]);

  $router->get('allprovincesbycountry/iso2/{countryCode}', [
    'as' => 'ilocation.api.get.allprovincesbycountry.iso2',
    'uses' => 'CountryController@allProvincesByCountryIso2',
  ]);

  $router->get('allprovincesbycountry/iso3/{countryCode}', [
    'as' => 'ilocation.api.get.allprovincesbycountry.iso3',
    'uses' => 'CountryController@allProvincesByCountryIso3',
  ]);
  $router->get('allcitiesbyprovince/{provinceId}', [
    'as' => 'ilocation.api.get.allcitiesbyprovince',
    'uses' => 'CountryController@allCitiesByProvinceId',
  ]);

});

