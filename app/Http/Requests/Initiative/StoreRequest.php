<?php

namespace App\Http\Requests\Initiative;

use App\Http\Requests\Request;
use App\Models\Initiative;
use App\Models\User;
use Gate;
use Illuminate\Contracts\Validation\Validator;

class StoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', Initiative::class);
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

    /**
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
