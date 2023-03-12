<?php

namespace App\Http\Requests;

use App\Models\Room;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
        if( (in_array($this->method(), ['PUT', 'PATCH']))){
          //  dd($this->segment(3));
    
            return [
               
                'room_name_en' => 'nullable|max:254|unique:rooms,rm_name_en,'.$this->segment(3),
                // 'room_name_en' => ['nullable',
                // Rule::unique('rooms')->ignore($this->rm_name_en)],
                'room_name_loc' => 'nullable|max:254|unique:rooms,rm_name_loc,'.$this->segment(3),
                'room_max_pax' => 'nullable|numeric|max:99',
                'room_phone_no' => 'nullable',
                'room_phone_ext' => 'nullable',
                'room_key_code' => 'nullable|min:3|max:254',
                'room_key_options' => 'nullable|min:3|max:254',
                'room_connection' => 'nullable|in:0,1',
                'fo_status' => 'nullable|in:VA,OC,OO,OS',
                'room_active' => 'nullable|min:1|max:254',
//                'hk_stauts' => 'nullable|in:DI,CN',
                'sort_order' => 'nullable|numeric',
                'room_type_id' => 'nullable|exists:room_types,id',
                'floor_id' => 'nullable|exists:room_types,id',
              
            ];
        }else{
            return [
                'room_name_en' => 'required|unique:rooms,rm_name_en|max:254',
                'room_name_loc' => 'nullable|unique:rooms,rm_name_loc|max:254',
                'room_max_pax' => 'nullable|numeric',
                'room_phone_no' => 'nullable',
                'room_phone_ext' => 'nullable',
                'room_key_code' => 'nullable|min:3|max:254',
                'room_key_options' => 'nullable|min:3|max:254',
                'room_connection' => 'nullable|in:0,1',
                'fo_status' => 'nullable|in:VA,OC,OO,OS',
                'room_active' => 'nullable|in:0,1',
                'sort_order' => 'nullable|numeric', 
                'room_type_id' => 'required|exists:room_types,id',
                'floor_id' => 'required|exists:room_types,id',

            ];
        }
    }
}
