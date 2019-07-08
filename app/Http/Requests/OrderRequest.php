<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return auth()->user()->can('create-orders');
        }
        if ($this->method() === 'PUT') {
            return auth()->user()->can('update-orders');
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
            case 'POST':
            case 'PUT': {
                return [
                    'cost' => 'required|numeric',
                    'notes' => 'string',
                    'created_at' => 'required',
                    'customer_id' => [
                        'required',
                        Rule::exists('customers', 'id')
                    ],
                    'payment_method_id' => [
                        'required',
                        Rule::exists('payment_methods', 'id')
                    ],
                ];
            }
        }
    }
}
