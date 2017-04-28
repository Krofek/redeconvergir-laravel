<?php
namespace App\Services;

use App\Models\Event;
use Auth;

class EventService
{
    private static function prepareData($data)
    {
        $data['url'] = str_slug($data['name']);
        return $data;
    }

    /**
     * C R U D
     * @param array $data
     * @return Event
     */
    public function crudCreate($data)
    {
        $data = static::prepareData($data);
        $event = \DB::transaction(function () use ($data) {
            $event = Event::create($data);
            $event->initiatives()->sync($data['initiatives']);
            # in future, $data['locations'] will be array of JSON strings because one initiative will be able to have multiple locations
            $location = LocationService::whereJsonOrFirst($data['locations']);
            $event->locations()->sync([$location->id]);
            $event->users()->attach(Auth::user()->id);
            return $event;
        });
        return $event;
    }

    /**
     * @param Event $event
     * @param array $data
     * @return Event
     */
    public function crudUpdate($event, $data)
    {
        $data = static::prepareData($data);
        $event = \DB::transaction(function () use ($data, $event) {
            $event->initiatives()->sync($data['initiatives']);
            # in future, $data['locations'] will be array of JSON strings because one initiative will be able to have multiple locations
            $location = LocationService::whereJsonOrFirst($data['locations']);
            $event->locations()->sync([$location->id]);
            $event->update($data);
            // TODO: making it possible for other users to edit event
            return $event;
        });
        return $event;
    }
}