<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class StoreValidate extends FormRequest
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
        if (Route::is('owner.pengaturan.daftar-toko.store')) {
            return [
                'name' => 'required',
                'description' => 'required',
                'province' => 'required',
                'regency' => 'required',
                'district' => 'required',
                'village' => 'required',
            ];
        } else if (Route::is('owner.pengaturan.daftar-toko.update')) {
            return [
                'name' => 'required',
                'description' => 'required',
            ];
        }
    }
}