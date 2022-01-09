<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'gender' => 'required|string',
            'civil_status' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'address' => 'required|string',
            'contact_number' => 'nullable|string',
        ];
    }
}
