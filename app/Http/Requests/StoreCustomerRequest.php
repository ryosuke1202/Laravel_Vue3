<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'name' => ['required', 'max:50'],
            'kana' => ['required', 'max:50'],
            'tel' => ['required', 'max:50'],
            'email' => ['required', 'max:50'],
            'postcode' => ['required', 'max:7'],
            'address' => ['required', 'max:50'],
            'birthday' => ['required', 'date'],
            'gender' => ['required'],
            'memo' => ['required', 'max:1000'],
        ];
    }
}
