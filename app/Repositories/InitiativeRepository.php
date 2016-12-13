<?php
/**
 * Created by PhpStorm.
 * User: krofek
 * Date: 7/8/16
 * Time: 8:11 PM
 */

namespace App\Repositories;


use App\Interfaces\InitiativeRepositoryInterface;
use App\Models\Initiative;
use App\Models\Initiative\Contact;
use App\Models\User;
use App\Services\InitiativeService;
use App\Services\LocationService;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class InitiativeRepository implements InitiativeRepositoryInterface
{
    /**
     * @var Initiative
     */
    protected $initiative;

    public function __construct()
    {
        $this->initiative = new Initiative();
    }

    public function getAll()
    {
        return $this->initiative->all();
    }

    public function find($id)
    {
        return $this->initiative->findOrFail($id);
    }

    /**
     * Returns a collection of Initiative objects which some user is authorized to manage.
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection|null|static[]
     */
    public function getManageableForUser(User $user)
    {
        if (!$user) return null;

        if ($user->can('manage initiatives')) {
            return $this->initiative->all();
        } else {
            return $user->initiatives()->get();
        }
    }

    /**
     * Returns a collection of Initiative objects which are within a given coordinate boundary
     * @param \stdClass $boundary
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function withinBoundary($boundary)
    {
        $lat = [$boundary->south, $boundary->north];
        $lng= [$boundary->west, $boundary->east];
        return $this->initiative->with(['categories', 'locations'])->whereHas('locations', function ($query) use($lat, $lng){
            $query
                ->whereBetween('locations.lat', $lat)
                ->whereBetween('locations.lng', $lng);
        })->get();
    }

    /**
     * filter by:
     * - category
     * - tags
     * - audience
     * - area type
     * - audience size
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|Initiative[]
     */
    public function filterFromRequest(Request $request)
    {
        $results = $this->initiative->with('category', 'otherCategory', 'tags', 'audience', 'location');

        if ($request->has('category_id')) {
            $this->filterOneToOne($results, 'category_id', $request);
        }

        if ($request->has('tags')) {
            $this->filterManyToOne($results, 'tags', $request);
        }

        if ($request->has('audience')) {
            $this->filterManyToOne($results, 'audience', $request);
        }

        if ($request->has('location_type')) {
            $this->filterOneToOne($results, 'location_type', $request);
        }

        if ($request->has('audience_size')) {
            $this->filterOneToOne($results, 'audience_size', $request);
        }

        return $results->get();
    }

    /**
     * @param Eloquent|Model|Builder $results
     * @param $type
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    private function filterManyToOne(&$results, $type, Request $request)
    {
        $names = [];
        foreach ($request->input($type) as $row) $names[] = config('initiatives.' . $type)[$row];
        return $results->whereHas($type, function ($query) use ($names) {
            /** @var Eloquent $query */
            $query->whereIn('name', $names);
        });
    }

    /**
     * @param Eloquent|Model|Builder $results
     * @param $type
     * @param Request $request
     * @return $this
     */
    private function filterOneToOne(&$results, $type, Request $request)
    {
        return $results->whereIn($type, $request->input($type));
    }

}