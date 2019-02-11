<?php

namespace App\Http\Requests;

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
     * @return array
     */
    public function rules()
    {
        return [
            'article' => 'required|string',
            'name' => 'required|string',
            'rostovka_count' => 'required|numeric',
            'box_count' => 'required|numeric',
            'prise' => 'required|numeric',
            'manufacturer_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'show_product' => 'required',
            'currency'  => 'required',
            'discount' => 'required|string',
            'accessibility' => 'required',
            'image_url' => 'required|image',
            'type_id' => 'required|numeric',
            'season_id' => 'required|numeric',
            'size_id' => 'required|numeric',
        ];
    }
}
