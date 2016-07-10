<?php
/**
 * Created by PhpStorm.
 * User: krofek
 * Date: 7/8/16
 * Time: 8:33 PM
 */

namespace App\Services;


use App\Models\Contact;
use App\Models\Initiative;
use App\Models\Initiative\Audience;
use App\Models\Initiative\Tag;
use App\Models\Location;
use Illuminate\Http\Request;

class InitiativeService
{

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

    private function setupCategory(Request $request, Initiative $initiative)
    {
        if ($request->input('category_id') === 0) {
            $initiative->otherCategory->create(['name' => $request->input('category_other')]);
        }
    }

    private function setupTags(Request $request, Initiative $initiative)
    {
        $tags = $request->input('tags');
        if (!empty($tags)) {
            foreach ($tags as $inputTag) {
                /** @var Tag $tag */
                $tag = $initiative->tags()->create(['name' => config('rede_initiative.tags')[$inputTag]]);
                if ($inputTag === 0) $tag->other()->create(['name' => $request->input('tags_other')]);
            }
        }
    }

    private function setupAudience(Request $request, Initiative $initiative)
    {
        $audience = $request->input('audience');
        if (!empty($audience)) {
            foreach ($audience as $inputAudience) {
                /** @var Audience $member */
                $member = $initiative->tags()->create(['name' => config('rede_initiative.audience')[$inputAudience]]);
                if ($inputAudience === 0) $member->other()->create(['name' => $request->input('audience_other')]);
            }
        }
    }

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

    private function setupDocs(Request $request, Initiative $initiative)
    {
        $doc = $request->file('doc');
        if ($doc) {
            $ext = $doc->getClientOriginalExtension();
            $name = $doc->getClientOriginalName();

            \Storage::put(
                'initiative/' . $initiative->id . '/docs/' . $name . '.' . $ext,
                file_get_contents($doc->getRealPath())
            );
        }
    }

    public function createFromRequest(Request $request)
    {
        \DB::transaction(function () use ($request) {

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

        });

    }
}