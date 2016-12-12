<?php

namespace App\Http\Requests\Event;

use App\Http\Requests\Request;
use App\Models\Event;
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
        $event = $this->route('event');
        return Gate::allows('update', $event);
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
