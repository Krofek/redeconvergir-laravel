<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Initiative;
use Zofe\Rapyd\DataFilter\DataFilter;
use \Serverfireteam\Panel\CrudController;

use Illuminate\Http\Request;

class InitiativeController extends CrudController{

    public function all($entity){
        parent::all($entity);

		$this->filter = DataFilter::source(new Initiative());
		$this->filter->add('category','Category','select')->options(Initiative\Category::pluck("name", "id")->all()); // Filter with Select List
		$this->filter->add('name', 'Name', 'text'); // Filter by String
		$this->filter->submit('search');
		$this->filter->reset('reset');
		$this->filter->build();

        /** Simple code of  filter and grid part , List of all fields here : http://laravelpanel.com/docs/master/crud-fields


			$this->filter = \DataFilter::source(new \App\Category);
			$this->filter->add('name', 'Name', 'text');
			$this->filter->submit('search');
			$this->filter->reset('reset');
			$this->filter->build();

			$this->grid = \DataGrid::source($this->filter);
			$this->grid->add('name', 'Name');
			$this->grid->add('code', 'Code');
			$this->addStylesToGrid();

        */
                 
        return $this->returnView();
    }
    
    public function  edit($entity){
        
        parent::edit($entity);

        /* Simple code of  edit part , List of all fields here : http://laravelpanel.com/docs/master/crud-fields
	
			$this->edit = \DataEdit::source(new \App\Category());

			$this->edit->label('Edit Category');

			$this->edit->add('name', 'Name', 'text');
		
			$this->edit->add('code', 'Code', 'text')->rule('required');


        */
       
        return $this->returnEditView();
    }    
}
