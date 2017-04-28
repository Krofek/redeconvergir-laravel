<?php

use App\Models\Initiative;
use App\Models\Initiative\Audience;
use App\Models\Initiative\Category;
use App\Models\Initiative\Tag;
use Geocoder\Result\Geocoded;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class InitiativeTest extends TestCase
{
    use DatabaseMigrations;

    public static $parameters = [
        'name'           => 'test',
        'url'            => '',
        'video_url'      => '',
        'logo_url'       => 'http://placehold.it/50x50',
        'doc_url'        => 'http://nonexistent.com',
        'description'    => "You think water moves fast? You should see ice. It moves like it has a mind. Like it knows it killed the world once and got a taste for murder. After the avalanche, it took us a week to climb out. Now, I don't know exactly when we turned on each other, but I know that seven of us survived the slide... and only five made it out. Now we took an oath, that I'm breaking now. We said we'd say it was the snow that killed the other two, but it wasn't. Nature is lethal but it doesn't hold a candle to man.",
        'start_at'       => '2016-12-12',
        'audience_size'  => 4,
        'group_size'     => 50,
        'area_size'      => 120,
        'accepts_visits' => 1,
        'location_type'  => 0,
        'status'         => 1,
        'promoter'       => '',

        'contact'  => [
            'street'      => 'Test',
            'city'        => 'Test',
            'postal_code' => '1000',
            'name'        => 'test contact',
            'email'       => 'test@tester.com',
            'phone'       => '',
            'other'       => ''
        ],
        'location' => [
            'lat' => 46.0375847,
            'lng' => 14.4887289
        ],
        'tags'     => [0, 1, 2],
        'tags_other' => 'testing_tag',
        'audience' => [0, 1, 2],
        'audience_other' => 'testing_audience'
    ];

    public function testCreation()
    {
        $service = new \App\Services\InitiativeService;

        $parameters = self::$parameters;

        // test other category
        /** @var Category $category */
        $category = factory(App\Models\Initiative\Category::class)->create(['name' => 'other']);

        $parameters['category_id'] = $category->id;
        $parameters['category_other'] = 'testing_category';

        /** @var Illuminate\Http\Request $request */
        $request = Request::create(route('initiative.store'), 'POST', $parameters);

        /** @var Initiative $initiative */
        $initiative = $service->createFromRequest($request);
        $this->assertEquals('testing_category', $initiative->category_name);

        // test with normal category
        $category = factory(App\Models\Initiative\Category::class)->create();
        $parameters['category_id'] = $category->id;

        $request = Request::create(route('initiative.store'), 'POST', $parameters);

        $initiative = $service->createFromRequest($request);

        $this->assertTrue($initiative->exists);
        $this->assertTrue($initiative->category->exists);

        $this->assertFalse($initiative->audience->isEmpty());
        $this->assertFalse($initiative->tags->isEmpty());

        $this->assertTrue($initiative->contact->exists);
        $this->assertTrue($initiative->location->exists);

        $this->assertTrue($initiative->audience->contains('real_name', 'testing_audience'));
        $this->assertTrue($initiative->tags->contains('real_name', 'testing_tag'));

        $this->assertFalse($initiative->docs->isEmpty());

        // assert is google location
        $this->assertInstanceOf(Geocoded::class, $initiative->location->getGoogleLocation());

        // lol - vem kje zvis madrfakr!!!
        $this->assertEquals('Cesta V Mestni Log', $initiative->location->getGoogleLocation()->getStreetName());
    }

    public function testWithUploadedLogoAndDocs()
    {
        $service = new \App\Services\InitiativeService;

        $parameters = self::$parameters;

        // test other category
        /** @var Category $category */
        $category = factory(App\Models\Initiative\Category::class)->create(['name' => 'other']);

        $parameters['category_id'] = $category->id;
        $parameters['category_other'] = 'testing_category';

        $logo = new UploadedFile(app_path('../tests/files/test-image.jpg'), 'test-image.jpg');
        $doc = new UploadedFile(app_path('../tests/files/test-doc.doc'), 'test-doc.doc');

        $files = compact('logo', 'doc');

        /** @var Illuminate\Http\Request $request */
        $request = Request::create(route('initiative.store'), 'POST', $parameters, [], $files);

        $initiative = $service->createFromRequest($request);

        $logo_url = '/storage/initiative/' . $initiative->id . '/logo';
        $this->assertFileExists(public_path($logo_url));
        $this->assertEquals($logo_url, $initiative->logo);

        $doc_url = '/storage/initiative/' . $initiative->id . '/docs/test-doc.doc';
        $this->assertFileExists(public_path($doc_url));
        $this->assertEquals(2, count($initiative->docs));

        File::deleteDirectory(public_path('storage/initiative/' . $initiative->id));
    }

    public function testStoreController()
    {
        $parameters = self::$parameters;

        $user = factory(App\Models\User::class)->create();

        /** @var Category $category */
        $category = factory(App\Models\Initiative\Category::class)->create();
        $parameters['category_id'] = $category->id;

        $response = $this->actingAs($user)->json('post', route('initiative.store'), $parameters);

        $response->arrayHasKey('id');
        $response->seeJson(['category_id' => $category->id]);

        /** @var Initiative $initiative */
        $initiative = Initiative::find($response->decodeResponseJson()['id']);

        $this->assertTrue($initiative->exists);
        $this->assertTrue($initiative->category->exists);

        $this->assertFalse($initiative->audience->isEmpty());
        $this->assertFalse($initiative->tags->isEmpty());

        $this->assertTrue($initiative->contact->exists);
        $this->assertTrue($initiative->location->exists);

        $this->assertFalse($initiative->docs->isEmpty());
    }

    public function testValidationError()
    {
        $parameters = self::$parameters;

        $user = factory(App\Models\User::class)->create();

        $this->actingAs($user)
            ->json('post', route('initiative.store'), $parameters)
            ->seeJson(['category_id' => [0 => 'The category id field is required.']]);
    }

    public function testFilters()
    {
        $number_of_categories = 8;
        /** @var Category[]|Collection $categories */
        $categories = factory(App\Models\Initiative\Category::class, $number_of_categories)->create();

        $initiatives = collect();
        $i = 0;
        /** @var Category $category */
        foreach($categories as $category) {
            if($i === 0) $category->name = 'other'; $category->save();
            $temp = factory(App\Models\Initiative::class, random_int(5, 15))->create(['category_id' => $category->id]);

            /** @var Initiative $initiative */
            foreach($temp as $initiative) {
                if($category->name === 'other') $initiative->otherCategory()->save(factory(App\Models\Initiative\Category\Other::class)->make());
                $tagsArray = UniqueRandomNumbersWithinRange(0, count(config('initiatives.tags')) - 1, random_int(1, 6));
                foreach($tagsArray as $tag) {
                    $name = config('initiatives.tags')[$tag];
                    /** @var Tag $t */
                    $t = $initiative->tags()->create(['name' => $name]);
                    if($name === 'other') $t->other()->save(factory(App\Models\Initiative\Tag\Other::class)->make());
                }
                $audienceArray = UniqueRandomNumbersWithinRange(0, count(config('initiatives.audience')) - 1, random_int(1, 5));
                foreach($audienceArray as $audience) {
                    $name = config('initiatives.audience')[$audience];
                    /** @var Audience $a */
                    $a = $initiative->audience()->create(compact('name'));
                    if($name === 'other') $a->other()->save(factory(App\Models\Initiative\Audience\Other::class)->make());
                }
                $initiative->save();
            }
            $initiatives->merge($temp);
            $i++;
        }

        $repository = new \App\Repositories\InitiativeRepository(new Initiative());

        /**
         * filter by:
         * - category
         * - tags
         * - audience
         * - area type
         * - audience sizes
         */

        $filters = ['category_id', 'tags', 'audience', 'location_type', 'audience_size'];

        // one by one
        foreach($filters as $filter) {
            /** @var Illuminate\Http\Request $request */

            if($filter === 'category_id') {
                $randomCategories = $categories->random(random_int(1, $number_of_categories));
                $intArray = $randomCategories->pluck('id')->toArray();
            }
            else {
                $intArray = UniqueRandomNumbersWithinRange(0, count(config('initiatives')[$filter]) - 1, random_int(1, 3));
            }

            $request = Request::create(null, 'POST', [ $filter => $intArray ]);

            $results = $repository->filterFromRequest($request);
            if($results) {
                foreach($results as $result) {
                    if($filter === 'category_id') {
                        $this->assertContains($result->category_id, $intArray);
                    }
                    elseif(in_array($filter, ['location_type', 'audience_size'])) {
                        $names = [];
                        foreach($intArray as $int) $names[] = config('initiatives')[$filter][$int];
                        $this->assertContains($result->$filter, $names);
                    }
                    else {
                        // check if at least one of them params exists in array
                        $names = collect();
                        if($intArray) foreach($intArray as $int) $names->push(config('initiatives')[$filter][$int]);
                        if($result->$filter) {
                            $this->assertGreaterThan(
                                0,
                                $names->intersect($result->$filter->pluck('name')->toArray())->count(),
                                implode(',', $names->toArray()) . '-' . $result->$filter->implode('name', ',')
                            );
                        }
                    }
                }
            }
        }

        // random two

        // random three

        // random four

        // all

    }
}
