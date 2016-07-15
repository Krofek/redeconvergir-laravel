<?php

namespace App\Http\Requests\Initiative;

use App\Http\Requests\Request;
use Auth;

class StoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        return Auth::user();
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = config('rede_initiative.input');

        $contact = [];
        foreach(config('rede_initiative.input_contact') as $key => $value) $contact['contact.'.$key] = $value;

        $location = [];
        foreach(config('rede_initiative.input_location') as $key => $value) $location['location.'.$key] = $value;

        $rules = array_merge($rules, $contact, $location);

        return $rules;
    }
}
