<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class AvailabilityRequest extends FormRequest
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
        $dateNow = Carbon::now();
        return [
            'startDate' => 'required|date|after:'.$dateNow,
            'endDate' => 'required|date|after:startDate',
            'roomType_id' => 'nullable|exists:room_types,id',
            'room_id' => 'nullable|exists:rooms,id',
        ];
    }
}
