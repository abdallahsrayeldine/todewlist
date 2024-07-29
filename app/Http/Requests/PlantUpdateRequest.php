<?php

namespace App\Http\Requests;

use App\Models\Plant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlantUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [

            'plant_path' => 'nullable|string',
            'name' => 'required|string',
            'species' => 'required|string',
            'water' => 'required|integer|min:0|max:5',
            'date' => 'required|date',
            'soil' => 'required|string',
            'drainage' => 'required|string',
            'fertilizer' => 'required|string',
            'sunlight' => 'required|integer|min:0|max:5',
            'humidity' => 'required|string',
            'notes' => 'nullable|string',

        ];
    }
}
