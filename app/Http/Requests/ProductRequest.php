<?php

namespace App\Http\Requests;

use App\Enums\Category;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
            'name' =>  'required',
            'category' =>  [
                'required',
                Rule::in(Category::all())
            ],
            'description' => 'required',
            'name_de' =>  'required',
            'description_de' => 'required',
            'is_active' => 'sometimes',
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
                Rule::dimensions()->maxHeight(1400)->maxWidth(1400)
            ];
        }

        if (!is_string($this->request->get('background'))) {
            $rules['background'] = [
                'image',
                Rule::dimensions()->maxHeight(2400)->maxWidth(2400)
            ];
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name_de.required' => 'The name field is required.',
            'description_de.required' => 'The description field is required.',
        ];
    }
}
