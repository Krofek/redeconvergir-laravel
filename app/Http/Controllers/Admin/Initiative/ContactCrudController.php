<?php namespace App\Http\Controllers\Admin\Initiative;

use App\Http\Requests\Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Requests\CrudRequest;

class ContactCrudController extends CrudController {

    public function __construct() {
        parent::__construct();

        $this->crud->setModel('App\Models\Initiative\Contact');
        $this->crud->setRoute("admin/contact");
        $this->crud->setEntityNameStrings('contact', 'contacts');

        $this->crud->setColumns(['name', 'email', 'phone', 'website', 'facebook']);
        $this->crud->addField([
            'name' => 'name',
            'label' => "Contact person"
        ]);
        $this->crud->addField([
            'name' => 'email',
            'type' => 'email',
            'label' => "Email"
        ]);
        $this->crud->addField([
            'name' => 'phone',
            'type' => 'text',
            'label' => "Phone"
        ]);
        $this->crud->addField([
            'name' => 'website',
            'type' => 'url',
            'label' => "Initiative website URL"
        ]);
        $this->crud->addField([
            'name' => 'facebook',
            'type' => 'url',
            'label' => "Initiative's facebook page URL"
        ]);
    }

    public function store(CrudRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(CrudRequest $request)
    {
        return parent::updateCrud();
    }
}