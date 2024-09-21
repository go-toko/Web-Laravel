<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ExpensesValidate extends FormRequest
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
        if (Route::is('owner.pengeluaran.pengeluaran.updateStatus')) {
            return [
                'status' => 'required',
            ];
        }
        return [
            'name' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'category' => 'required',
            'image' => 'required|file|image|max:2048'
        ];
    }
}
