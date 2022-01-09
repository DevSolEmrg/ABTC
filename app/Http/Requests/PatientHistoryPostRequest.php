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
            'registration_number' => 'nullable',
            'registration_date' => 'nullable|string',
            'age_of_patient' => 'nullable',
            'date_of_incident' => 'string',
            'place_of_incident' => 'string',
            'date_of_physical_exam' => 'string',
            'place_of_physical_exam' => 'string',
            'type_of_animal_id' => 'required|exists:App\Models\Reference,id',
            'type_of_exposure_id' => 'required|exists:App\Models\Reference,id',
            'site_of_infection_id' => 'required|array',
            'is_washed' => 'boolean',
            'rig_date_given' => 'nullable|string',
            'route' => 'string',
            'category_id' => 'required|exists:App\Models\Reference,id',
            'outcome_id' => 'required|exists:App\Models\Reference,id',
            'biting_animal_status_id' => 'required|exists:App\Models\Reference,id',
            'doctors_order' => 'nullable|string',
            'nurses_notes' => 'nullable|string',
            'remarks' => 'nullable|string'
        ];
    }
}
