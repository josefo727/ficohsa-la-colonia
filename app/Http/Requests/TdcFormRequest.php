<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TdcFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'number' => ['required'],
            'cvv2' => ['required'],
            'expire_month' => ['required'],
            'expire_year' => ['required'],
            'cardholder' => ['required'],
            'address' => ['required'],
            'country' => ['required'],
            'state' => ['required'],
            'city' => ['required'],
            'phone' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'number.required' => 'El campo número de tarjeta es obligatorio.',
            'cvv2.required' => 'El campo CVV2 es obligatorio.',
            'expire_month.required' => 'El campo mes de vencimiento es obligatorio.',
            'expire_year.required' => 'El campo año de vencimiento es obligatorio.',
            'cardholder.required' => 'El campo titular de la tarjeta es obligatorio.',
            'address.required' => 'El campo dirección es obligatorio.',
            'country.required' => 'El campo país es obligatorio.',
            'state.required' => 'El campo departamento es obligatorio.',
            'city.required' => 'El campo ciudad es obligatorio.',
            'phone.required' => 'El campo teléfono es obligatorio.',
        ]
    }
}
