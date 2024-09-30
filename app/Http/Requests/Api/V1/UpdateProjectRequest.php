<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
                'date' => ['required'],
                'client' => ['required'],
                'phone' => ['required'],
                'email' => ['required', 'email'],
                'sales' => ['required'],
                'installer' => ['sometimes', 'nullable'],
                'address' => ['sometimes'],
                'amounts' => ['sometimes', 'nullable'],
                'progress' => ['sometimes', 'nullable'],
                'completed' => ['sometimes', 'nullable'],
                'clientSatisfaction' => ['sometimes', 'nullable'],
                'notes' => ['sometimes', 'nullable'],
                'currency' => ['sometimes', 'nullable']
            ];    
        }else{
            return [
                'date' => ['sometimes'],
                'client' => ['sometimes'],
                'phone' => ['sometimes'],
                'sales' => ['sometimes'],
                'email' => ['sometimes'],
                'installer' => ['sometimes', 'nullable'],
                'address' => ['sometimes'],
                'amounts' => ['sometimes', 'nullable'],
                'progress' => ['sometimes', 'nullable'],
                'completed' => ['sometimes', 'nullable'],
                'clientSatisfaction' => ['sometimes', 'nullable'],
                'zs2' => ['sometimes', 'nullable'],
                'ffu' => ['sometimes', 'nullable'],
                'zef' => ['sometimes', 'nullable'],
                'zrh' => ['sometimes', 'nullable'],
                'notes' => ['sometimes', 'nullable'],
                'currency' => ['sometimes', 'nullable']
            ]; 
        }
    }

    protected function prepareForValidation(){
        if($this->has('clientSatisfaction')){
            $this->merge([
                'client_satisfaction' => $this->clientSatisfaction
            ]);    
        }
    }
}
