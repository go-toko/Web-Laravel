<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class CategoryValidate extends FormRequest
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
        if (Route::is('owner.produk.kategori.store')) {
            return [
                'name' => 'required',
            ];
        } elseif (Route::is('owner.produk.kategori.update')) {
            return [
                'name' => 'required',
            ];
        }
    }
}
