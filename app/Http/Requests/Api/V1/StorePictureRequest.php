<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePictureRequest extends FormRequest
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
            'name' => ['required'],
            'url' => ['required'],
            'houseCode' => ['required'],
            'houseId' => ['required'],
            'type' => ['required', Rule::in(['H', 'D', 'C', 'S', 'h', 'd', 'c', 's' ])]
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'house_code' => $this->houseCode,
            'house_id' => $this->houseId,
        ]);
    }

}
