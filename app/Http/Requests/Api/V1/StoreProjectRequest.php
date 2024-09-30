<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
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
            'date' => ['required'],
            'houseCode' => ['required'],
            'houseId' => ['required'],
            'client' => ['required'],
            'phone' => ['required'],
            'sales' => ['required'],
            'installer' => ['sometimes', 'nullable'],
            'address' => ['sometimes', 'nullable'],
            'amounts' => ['sometimes', 'nullable'],
            'progress' => ['sometimes', 'nullable'],
            'completed' => ['sometimes', 'nullable'],
            'clientSatisfaction' => ['sometimes', 'nullable'],
            'zs2' => ['sometimes', 'nullable'],
            'ffu' => ['sometimes', 'nullable'],
            'zef' => ['sometimes', 'nullable'],
            'zrh' => ['sometimes', 'nullable'],
            'notes' => ['sometimes', 'nullable'],
            'currency'=> ['sometimes', 'nullable']
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'house_code' => $this->houseCode,
            'house_id' => $this->houseId,
            'client_satisfaction' => $this->clientSatisfaction
        ]);
    }
}
