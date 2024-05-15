<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;


class UpdateRoomRequest extends FormRequest
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
        $method = $this->method();
        if($method == 'PUT'){
            return [
                'roomId' => ['required'],
                'name' => ['required'],
                'houseCode' => ['required'],
                'houseId' => ['required'],
                'length' => ['sometimes'],
                'width' => ['sometimes'],
                'height' => ['sometimes'],
                'outdoorPm25' => ['sometimes']
            ];
        }else{
            return [
                'name' => ['sometimes'],
                'length' => ['sometimes'],
                'width' => ['sometimes'],
                'height' => ['sometimes'],
                'outdoorPm25' => ['sometimes']
            ];
        }   
    }

    protected function prepareForValidation(){
        // \Log::info('PrepareForValidation is called.');
        if ($this->has('outdoorPm25')) {
            $this->merge([
                'outdoor_pm25' => $this->outdoorPm25,
            ]);
        }
    }
}
 