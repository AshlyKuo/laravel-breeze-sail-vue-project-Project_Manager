<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'roomId' => ['required'],
            'name' => ['required'],
            'houseCode' => ['required'],
            'houseId' => ['required'],
            'length' => ['required'],
            'width' => ['required'],
            'height' => ['required'],
            'outdoorPm25' => ['required']
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'room_id' => $this->roomId,
            'house_code' => $this->houseCode,
            'house_id' => $this->houseId,
            'outdoor_pm25' => $this->outdoorPm25
        ]);
    }
}
