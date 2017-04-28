<?php

namespace App\Http\Requests\Event;

use App\Http\Requests\Request;
use App\Models\Event;
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
        return Gate::allows('create', Event::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = config('events.input');
        return $rules;
    }
}
