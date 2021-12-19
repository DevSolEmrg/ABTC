<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientHistoryPostRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'patient_id' => 'required|exists:App\Models\Patient,id',
            'date_of_incident' => 'string',
            'place_of_incident' => 'string',
            'date_of_physical_exam' => 'string',
            'place_of_physical_exam' => 'string',
            'type_of_animal_id' => 'required|exists:App\Models\Reference,id',
            'type_of_exposure_id' => 'required|exists:App\Models\Reference,id',
            'site_of_infection_id' => 'required|array',
            'is_washed' => 'boolean',
            'route' => 'string',
            'category_id' => 'required|exists:App\Models\Reference,id',
            'outcome_id' => 'required|exists:App\Models\Reference,id',
            'biting_animal_status_id' => 'required|exists:App\Models\Reference,id',
            'remarks' => 'string'
        ];
    }
}
