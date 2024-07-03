<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;

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
                'name' => 'required',
                'gender' => 'required',
                'email' => 'required|email',
                'username' => 'required|unique:user_cashier,username',
                'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:8|required_with:password|same:password',
            ];
        } else if (Route::is('owner.orang.kasir.update')) {
            return [
                'status' => 'required',
            ];
        }
    }
}
