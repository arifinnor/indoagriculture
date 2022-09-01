<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' =>  'required|string|min:3',
            'description' => 'required',
            'is_active' => 'sometimes|boolean',
            'thumbnail' => [
                'required'
            ],
            'background' =>  [
                'required'
            ],
            'attrs.*.id' => 'nullable',
            'attrs.*.value' => 'nullable',
        ];

        if (!is_string($this->request->get('thumbnail'))) {
            $rules['thumbnail'] = [
                'image',
                Rule::dimensions()->ratio(1 / 1)->maxHeight(1200)->maxWidth(1200)
            ];
        }

        if (!is_string($this->request->get('background'))) {
            $rules['background'] = [
                'image',
                Rule::dimensions()->ratio(1 / 1)->maxHeight(1200)->maxWidth(1200)
            ];
        }

        return $rules;
    }
}
