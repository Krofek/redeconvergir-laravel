<?php
namespace App\Services;

use App\Models\Location;

class LocationService
{
    static public function dataFromJSON($json)
    {
        $json = json_decode($json);

        if(json_last_error() === JSON_ERROR_NONE){
            $locationArray = ['name' => $json->value, 'lat' => $json->latlng->lat, 'lng' => $json->latlng->lng, 'json' => json_encode($json)];
            return $locationArray;
        }else{
            throw new \Exception('Not JSON.');
        }
    }
    
    static public function dataFromInitativeForm($location)
    {
        return array_merge(static::dataFromJSON($location['json']), array_except($location, 'json'));
    }
    
    static public function whereJson($json)
    {
        $result = Location::where('json', $json)->get();
        if($result->isEmpty()){
            return null;
        }else{
            return $result->first();
        }
    }

    /**
     * @param $json
     * @return Location
     */
    static public function whereJsonOrFirst($json)
    {
        $existingLocation = static::whereJson($json);
        if($existingLocation){
            return $existingLocation;
        }else{
            return Location::create(static::dataFromJSON($json));
        }
    }
}