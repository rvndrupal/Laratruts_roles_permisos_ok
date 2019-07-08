<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return auth()->user()->can('create-customers');
        }
        if ($this->method() === 'PUT') {
            return auth()->user()->can('update-customers');
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
                    'name' => 'required|min:2|unique:customers',
                    'surname' => 'required|min:4',
                    'phone' => 'required|min:9',
                    'address' => 'required|min:4',
                    'payment_methods' => 'required|array'
                ];
            }
            case 'PUT': {
                return [
                    'name' => 'required|unique:customers,name,'.$this->id.'|min:2',
                    'surname' => 'required|min:4',
                    'phone' => 'required|min:9',
                    'address' => 'required|min:4',
                    'payment_methods' => 'required|array'
                ];
            }
        }
    }
}
