<?php
/**
 * Created by PhpStorm.
 * User: krofek
 * Date: 7/8/16
 * Time: 8:33 PM
 */

namespace App\Services;


use App\Models\Initiative;
use App\Models\Initiative\Audience;
use App\Models\Initiative\Category;
use App\Models\Initiative\Contact;
use App\Models\Initiative\Tag;
use App\Models\Location;
use App\Repositories\InitiativeRepository;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class InitiativeService
{
    /**
     * C R U D
     * -------
     * Location, audience and contact are non-standard Backpack\CRUD fields and must thus be treated differently.
     * Methods are defined in Services\InitiativeService and Repositories\InitiativeRepository.
     *
     * Crud create
     * @param array $data
     * @return Initiative
     */
    public function crudCreate($data){
        $data = static::prepareData($data);
        $initiative = \DB::transaction(function () use ($data) {
            /** @var Initiative $initiative */
            $initiative = Initiative::create($data);
            /**
             * TODO:
             * - create url
             */
            $contact = new Contact($data['contact']);
            $initiative->contact()->save($contact);
            /** @var Location $location */
            # in future, $data['locations'] will be array of JSON strings because one initiative will be able to have multiple locations
            $location = LocationService::whereJsonOrFirst($data['locations']);
            $initiative->locations()->sync([$location->id]);
            $audience = static::audienceForSync($data['audience'], $data['audience_other']);
            $initiative->audience()->sync($audience);
            $initiative->categories()->sync($data['categories']);
            $initiative->users()->attach(Auth::user()->id);
            return $initiative;
        });
        return $initiative;
    }

    /**
     * @param array $data
     * @param Initiative $initiative
     * @return Initiative
     */
    public function crudUpdate($initiative, $data){
        $data = static::prepareData($data);
        $initiative = \DB::transaction(function () use ($data, $initiative) {
            $initiative->contact->update($data['contact']);
            /** @var Location $location */
            # in future, $data['locations'] will be array of JSON strings because one initiative will be able to have multiple locations
            $location = LocationService::whereJsonOrFirst($data['locations']);
            $initiative->locations()->sync([$location->id]);
            $initiative->audience()->sync(InitiativeService::audienceForSync($data['audience'], $data['audience_other']));
            $initiative->categories()->sync($data['categories']);
            $initiative->update($data);
            // TODO: making it possible for other users to edit event
            return $initiative;
        });

        return $initiative;
    }

    /**
     * Prepares array if audience ids for sync with potential "name" column filled out for "Other" audience.
     *
     * @param array $audience
     * @param string $audience_other
     * @return array
     */
    public static function audienceForSync($audience, $audience_other = NULL)
    {
        if($audience_other != NULL){
            $other_id = config('initiatives.audience_other_id');
            $return = [$other_id => ['name' => $audience_other]];
            foreach ($audience as $id){
                $return[] = $id;
            }
        }else{
            $return = $audience;
        }
        return $return;
    }

    /**
     * Adds empty array values for audience and categories when no multiple-select option is chosen.
     * (Multiple select form element does not get submitted at all (not even as empty array).)
     * Also, creates url slug.
     *
     * @param array $data
     * @return array
     */
    public static function prepareData($data)
    {
        if(!isset($data['categories'])){
            $data['categories'] = [];
        }
        if(!isset($data['audience'])){
            $data['audience'] = [];
        }
        $data['url'] = str_slug($data['name']);
        return $data;
    }

    /**
     * Create a contact, create a new location, create initiative with contact and location.
     *
     * @param Request $request
     * @return Initiative
     */
    private function setupInitiative(Request $request)
    {
        /** @var Contact $contact */
        $contact = Contact::create($request->input('contact'));
        /** @var Location $location */
        $location = Location::create($request->input('location'));

        $data = $request->all();
        $data['contact_id'] = $contact->id;
        $data['location_id'] = $location->id;

        return Initiative::create($data);
    }

    /**
     * Predetermined category or a custom one defined by user
     *
     * @param Request $request
     * @param Initiative $initiative
     */
    private function setupCategory(Request $request, Initiative $initiative)
    {
        if (Category::find($request->input('category_id'))->name === 'other') {
            $initiative->otherCategory()->create(['name' => $request->input('category_other')]);
        }
    }

    /**
     * Insert predetermined tags or with custom name if user chose other
     *
     * @param Request $request
     * @param Initiative $initiative
     */
    private function setupTags(Request $request, Initiative $initiative)
    {
        $tags = $request->input('tags');
        if (!empty($tags)) {
            foreach ($tags as $inputTag) {
                /** @var Tag $tag */
                $tag = $initiative->tags()->create(['name' => config('initiatives.tags')[$inputTag]]);
                if ($inputTag === 0) $tag->other()->create(['name' => $request->input('tags_other')]);
            }
        }
    }

    /**
     * Insert predetermined audience or with custom name if user chose other
     *
     * @param Request $request
     * @param Initiative $initiative
     */
    private function setupAudience(Request $request, Initiative $initiative)
    {
        $audience = $request->input('audience');
        if (!empty($audience)) {
            foreach ($audience as $inputAudience) {
                /** @var Audience $member */
                $member = $initiative->audience()->create(['name' => config('initiatives.audience')[$inputAudience]]);
                if ($inputAudience === 0) $member->other()->create(['name' => $request->input('audience_other')]);
            }
        }
    }

    /**
     * Url to logo or replace with uploaded logo
     *
     * @param Request $request
     * @param Initiative $initiative
     */
    private function setupLogo(Request $request, Initiative $initiative)
    {
        $logo = $request->file('logo');
        if ($logo) {
            \Storage::put(
                'initiative/' . $initiative->id . '/logo',
                file_get_contents($logo->getRealPath())
            );

            $initiative->logo_url = null;
        }
    }

    /**
     * Put the docs into initiative. Upload doc and/or url to doc
     *
     * @param Request $request
     * @param Initiative $initiative
     */
    private function setupDocs(Request $request, Initiative $initiative)
    {
        $doc = $request->file('doc');
        if ($doc) {
            $name = $doc->getClientOriginalName();

            \Storage::put(
                'initiative/' . $initiative->id . '/docs/' . $name,
                file_get_contents($doc->getRealPath())
            );
        }
    }

    /**
     * Create an entire initiative through a database transaction. Rollback if the initiative didnt create successfully.
     *
     * @param Request $request
     * @return Initiative
     * @throws \Exception
     */
    public function createFromRequest(Request $request)
    {
        DB::beginTransaction();

        try {
            $initiative = $this->setupInitiative($request);

            // setup category
            $this->setupCategory($request, $initiative);

            // setup tags
            $this->setupTags($request, $initiative);

            // setup audience
            $this->setupAudience($request, $initiative);

            // setup logo
            $this->setupLogo($request, $initiative);

            // setup docs
            $this->setupDocs($request, $initiative);

            $initiative->save();

            // all good
        } catch (\Exception $e) {
            // something went wrong
            DB::rollback();

            dd($e->getTraceAsString());

            throw new \Exception('Error creating initiative: ' . $e->getMessage());
        }

        DB::commit();

        return $initiative;
    }
}