<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return auth()->user()->can('create-products');
        }
        if ($this->method() === 'PUT') {
            return auth()->user()->can('update-products');
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
                    'name' => 'required|min:2|unique:products',
                    'description' => 'required|min:10',
                    'price' => 'required|numeric',
                    'stock' => 'required|numeric',
                    'category_id' => [
                        'required',
                        Rule::exists('categories', 'id')
                    ],
                    'tags' => 'required|array',
                ];
            }
            case 'PUT': {
                return [
                    'name' => 'required|unique:products,name,'.$this->id.'|min:2',
                    'description' => 'required|min:10',
                    'price' => 'required|numeric',
                    'stock' => 'required|numeric',
                    'category_id' => [
                        'required',
                        Rule::exists('categories', 'id')
                    ],
                    'tags' => 'required|array',
                ];
            }
        }
    }
}
