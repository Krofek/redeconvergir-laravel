<?php namespace App\Http\Controllers\Admin\Initiative;

use Alert;
use App\Http\Requests\Initiative\UpdateRequest;
use App\Models\Initiative;
use App\Models\User;
use App\Services\InitiativeService;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Initiative\StoreRequest as StoreRequest;
use Redirect;

class InitiativeCrudController extends CrudController {

    protected $service;

    public function __construct(InitiativeService $service) {

        $this->service = $service;
        parent::__construct();
//        $this->crud = new InitiativeCrudPanel();

        $this->crud->setModel('App\Models\Initiative');
        $this->crud->setRoute("admin/initiative");
        $this->crud->setEntityNameStrings('initiative', 'initiatives');

//        $this->crud->setColumns(['name', 'category', 'contact', 'location', 'url']);
        /**
         * -----------------------------------------------------------------
         * Columns
         * -----------------------------------------------------------------
         */
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Name'
        ]);
        $this->crud->addColumn([
            'label' => 'Category',
            'type' => "select_multiple",
            'name' => 'categories', // the method that defines the relationship in your Model
            'entity' => 'categories', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => 'App\Models\Initiative\Category', // foreign key model
        ]);
        $this->crud->addColumn([
            // 1-n relationship
            'label' => "Contact", // Table column heading
            'type' => "select",
            'name' => 'contact_id', // the column that contains the ID of that connected entity;
            'entity' => 'contact', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => 'App\Models\Initiative\Contact', // foreign key model
        ]);
        /**
         * -----------------------------------------------------------------
         * Fields
         * -----------------------------------------------------------------
         */
        $this->crud->addField([
            'name' => 'name',
            'label' => "Name",
            'type' => 'text',
        ]);
        $this->crud->addField([   // Date
            'name' => 'start_at',
            'label' => 'Starting date',
            'type' => 'date_picker',
            'default' => \Date::now()->format('Y-m-d')
        ]);
        $this->crud->addField([
            'name' => 'categories',
            'label' => 'Category',
            'type' => 'select2_multiple',
            'entity' => 'category',
            'model' => 'App\Models\Initiative\Category',
            'attribute' => 'name',
            'pivot' => true
        ]);
        $this->crud->addField([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'radio',
//            'inline' => true,
            'options' => array_map(function($val){
                return trans("initiative.status." . $val);
            }, config('initiatives.status'))
        ]);
        /**
         * People
         */
        $this->crud->addField([
            'type' => 'division',
            'name' => 'division_people',
            'label' => 'People'
        ]);
        $this->crud->addField([
            'name' => 'group_size',
            'label' => "Number of people actively involved",
            'type' => 'number',
            'prefix' => "People",
        ]);
        /*
         * Next one is special.
         * Funkcionalnost naslednjega fielda je to, da zna prebrati iz pivoting tabele dodaten atribut.
         * Vse iniciative, ki se povežejo z 'Other', se povežejo zgolj zato, ker uporabnik izpolni field
         * "audience_other" (uporabnik ne more izbrati "other" iz select multiple). V pivoting tabeli je vrednost
         * "audience_other" fielda.
         * https://laravel.com/docs/5.3/eloquent-relationships => Retrieving Intermediate Table Columns
         */
        $this->crud->addField([
            'name' => 'audience',
            'label' => 'Audience',
            'type' => 'select2_multiple_and_text',
            'entity' => 'audience',
            'model' => 'App\Models\Initiative\Audience',
            'attribute' => 'name',
            'pivot' => true,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            # other
            'other_id' => config('initiatives.audience_other_id'), # id of 'Other', we don't show it in multiple select
            'pivot_column' => 'name', # name of additional column in pivot table
            'label_other' => 'Audience (other)',
            'name_other' => 'audience_other', # merely name of text input
            'placeholder_other' => 'Fill if target audience not listed (e.g. \'families, elderly\')'
        ]);
        $this->crud->addField([
            'name' => 'audience_size',
            'label' => 'Audience size',
            'type' => 'select_from_array',
            'allows_null' => false,
            'options' => config('initiatives.audience_size')
        ]);
        $this->crud->addField([
            'type' => 'division',
            'name' => 'division_location',
            'label' => 'Location'
        ]);
        $this->crud->addField([
            'name' => 'locations',
            'label' => 'Location',
            'type' => 'address',
            'store_as_json' => true,
        ]);
        $this->crud->addField([
            'name' => 'location_type',
            'label' => 'Location type',
            'type' => 'radio',
            'inline' => true,
            'options' => array_map(function($val){
                return trans("initiative.location_type." . $val);
            }, config('initiatives.location_type'))
        ]);
        $this->crud->addField([
            'name' => 'area_size',
            'label' => 'Area size',
            'type' => 'number',
            'prefix' => "Ha",
        ]);
        $this->crud->addField([
            'type' => 'division',
            'name' => 'division_media',
            'label' => 'Media'
        ]);
        $this->crud->addField([ // image
            'label' => "Logo",
            'name' => "logo_url",
            'type' => 'image',
            'upload' => true,
            'crop' => true, // set to true to allow cropping, false to disable,
            'placeholder' => url('uploads/logos/placeholder.jpg'),
            'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
        ]);
        $this->crud->addField([ // image
            'label' => "Cover photo",
            'name' => "cover_photo_url",
            'type' => 'image',
            'upload' => true,
            'crop' => true, // set to true to allow cropping, false to disable,
            'placeholder' => url('uploads/covers/placeholder.jpg'),
            'aspect_ratio' => config('initiatives.images.cover_photo.width')/config('initiatives.images.cover_photo.height'),
        ]);
//        $this->crud->addField([
//           ''
//        ]);
        $this->crud->addField([
            'label' => "Contact & Social",
            'type' => 'grouped', // custom method
            'name' => 'contact', // nested input name (e.g. "contact" in contact[name])
            'crud_controller' => new ContactCrudController() // crud controller from which we scrape fields
        ]);
        $this->crud->addField([
            'type' => 'division',
            'name' => 'division_description',
            'label' => 'Description'
        ]);
        $this->crud->addField([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'simplemde'
        ]);

    }

    public function store(StoreRequest $request)
    {
        $initiative = $this->service->crudCreate($request->except(['redirect_after_save', 'password']));
        Alert::success(trans('backpack::crud.insert_success'))->flash();
        return Redirect::to($this->crud->route);
    }

    public function update(UpdateRequest $request, Initiative $initiative)
    {
        $this->service->crudUpdate($initiative, $request->except('redirect_after_save', 'password'));
        Alert::success(trans('backpack::crud.update_success'))->flash();
        return Redirect::to($this->crud->route);
    }
}