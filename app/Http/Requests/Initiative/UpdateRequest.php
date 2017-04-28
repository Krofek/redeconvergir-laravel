<?php

namespace App\Http\Requests\Initiative;

use App\Http\Requests\Request;
use Gate;

class UpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $initiative = $this->route('initiative');
        return Gate::allows('update', $initiative);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = config('initiatives.input');
        // on update, exclude id of initiative being updated from unique names list
        if(!empty($this->get('id'))){
            $rules['name'] .= ',' . $this->get('id');
        }
        return $rules;
    }
}
