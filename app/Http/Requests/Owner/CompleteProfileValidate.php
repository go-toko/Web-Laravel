<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class CompleteProfileValidate extends FormRequest
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
            'firstName' => 'required',
            'lastName' => 'required',
            'nickName' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'birthDate' => 'required|date',
            'address' => '',

            'nameBusiness' => 'required',
            'provinceBusiness' => 'required',
            'regencyBusiness' => 'required',
            'districtBusiness' => 'required',
            'villageBusiness' => 'required',
            'addressBusiness' => '',
        ];
    }
}
