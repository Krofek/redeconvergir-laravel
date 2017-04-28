<?php namespace App\Http\Controllers\Admin\Initiative;

use App\Http\Requests\Initiative\AudienceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class AudienceCrudController extends CrudController {

    public function __construct() {
        parent::__construct();

        $this->crud->setModel('App\Models\Initiative\Audience');
        $this->crud->setRoute("admin/audience");
        $this->crud->setEntityNameStrings('audience', 'audiences');

        $this->crud->setColumns(['name']);
        $this->crud->addField([
            'name' => 'name',
            'label' => "Name"
        ]);
    }

    public function store(AudienceRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(AudienceRequest $request)
    {
        return parent::updateCrud();
    }
}