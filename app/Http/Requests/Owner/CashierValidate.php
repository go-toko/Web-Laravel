<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;

use function PHPSTORM_META\map;

class CashierValidate extends FormRequest
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
        if (Route::is('owner.orang.kasir.store')) {
            return [
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'phone' => 'required',
                'shop' => 'required',
                'email' => 'required|email|unique:users,email',
                'nickname' => 'required',
                'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:8|required_with:password|same:password',
            ];
        } else if (Route::is('owner.orang.kasir.updateOrDeleteAkses')) {
            return [
                'shopId' => 'required',
                'cashierId' => 'required',
                'value' => 'required'
            ];
        }
    }
}
