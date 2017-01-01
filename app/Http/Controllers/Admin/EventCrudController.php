<?php namespace App\Http\Controllers\Admin;

use Alert;
use App\Http\Requests\Event\StoreRequest;
use App\Http\Requests\Event\UpdateRequest;
use App\Models\Event;
use App\Repositories\InitiativeRepository;
use App\Services\EventService;
use Auth;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Routing\Router;
use Redirect;

class EventCrudController extends CrudController
{

    protected $service;
    protected $initiative;
    protected $user;

    public function setup()
    {
        $this->initiative = new InitiativeRepository();
        $this->service = new EventService();
        parent::__construct();

        $this->crud->setModel('App\Models\Event');
        $this->crud->setRoute("admin/event");
        $this->crud->setEntityNameStrings('event', 'events');

        $this->crud->setColumns(['name', 'start_at', 'end_at']);
        $this->crud->addField([
            'name'  => 'name',
            'label' => "Name"
        ]);
        $this->crud->addField([
            'name'  => 'website',
            'type'  => 'url',
            'label' => "Event website or link"
        ]);
        $this->crud->addField([   // Date
            'name'    => 'start_at',
            'label'   => 'Starting date',
            'type'    => 'datetime_picker',
            'default' => \Date::createFromTime(12)->format('Y-m-d H:i:s')
        ]);
        $this->crud->addField([   // Date
            'name'    => 'end_at',
            'label'   => 'End date',
            'type'    => 'datetime_picker',
            'default' => \Date::createFromTime(13)->format('Y-m-d H:i:s')
        ]);
        $this->crud->addField([
            'name'          => 'locations',
            'label'         => 'Location',
            'type'          => 'address',
            'store_as_json' => true,
        ]);
        $this->crud->addField([
            'name'      => 'initiatives',
            'label'     => 'Organizators (initiatives)',
            'type'      => 'select2_multiple',
            'entity'    => 'initiative',
            'options'   => $this->initiative->getManageableForUser(Auth::user()),
            'model'     => 'App\Models\Initiative',
            'attribute' => 'name',
            'hint'      => 'You can add only initiatives that you (' . Auth::user()->name . ') manage.',
            'pivot'     => true
        ]);
        $this->crud->addField([
            'name'  => 'description',
            'label' => 'Description',
            'type'  => 'simplemde'
        ]);





    }

    public function store(StoreRequest $request)
    {
        $event = $this->service->crudCreate($request->except(['redirect_after_save', 'password']));
        Alert::success(trans('backpack::crud.insert_success'))->flash();
        return Redirect::to($this->crud->route);
    }

    public function update(UpdateRequest $request, Event $event)
    {
        $this->service->crudUpdate($event, $request->except('redirect_after_save', 'password'));
        Alert::success(trans('backpack::crud.update_success'))->flash();
        return Redirect::to($this->crud->route);
    }
}