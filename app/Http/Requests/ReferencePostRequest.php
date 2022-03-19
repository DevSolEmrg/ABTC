<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReferencePostRequest extends FormRequest
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
            'reference_category_id' => 'required|exists:App\Models\ReferenceCategory,id',
            'code' => 'required|string',
            'desc' => 'nullable|string'
        ];
    }
}
