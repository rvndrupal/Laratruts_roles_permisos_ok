<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return auth()->user()->can('create-payment-methods');
        }
        if ($this->method() === 'PUT') {
            return auth()->user()->can('update-payment-methods');
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
            case 'DELETE':
                return [];
            case 'POST': {
                return [
                    'name' => 'required|min:4',
                    'description' => 'required|min:10',
                ];
            }
            case 'PUT': {
                return [
                    'name' => 'required|unique:payment_methods,name,'.$this->id.'|min:4',
                    'description' => 'required|min:10',
                ];
            }
        }
    }
}
