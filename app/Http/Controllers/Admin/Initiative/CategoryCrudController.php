<?php namespace App\Http\Controllers\Admin\Initiative;

use App\Http\Requests\Initiative\CategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class CategoryCrudController extends CrudController {

    public function __construct() {
        parent::__construct();

        $this->crud->setModel('App\Models\Initiative\Category');
        $this->crud->setRoute("admin/category");
        $this->crud->setEntityNameStrings('category', 'categories');

        $this->crud->setColumns(['name', 'description']);
        $this->crud->addField([
            'name' => 'name',
            'label' => "Category Name"
        ]);
        $this->crud->addField([
            'name' => 'description',
            'label' => "Description"
        ]);
    }

    public function store(CategoryRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(CategoryRequest $request)
    {
        return parent::updateCrud();
    }
}