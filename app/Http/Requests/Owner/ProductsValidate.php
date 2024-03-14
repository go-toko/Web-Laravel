<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class ProductsValidate extends FormRequest
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
        return [
            'name' => 'required',
            'sku' => 'required',
            'quantity' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
            'category' => 'required',
            'brand' => 'required',
            'image' => 'file|image|max:2048'
        ];
    }
}
