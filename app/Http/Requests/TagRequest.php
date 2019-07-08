<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return auth()->user()->can('create-tags');
        }
        if ($this->method() === 'PUT') {
            return auth()->user()->can('update-tags');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'name' => 'required|min:2|unique:tags'
                ];
            }
            case 'PUT': {
                return [
                    'name' => 'required|unique:tags,name,'.$this->id.'|min:2'
                ];
            }
        }
    }
}
