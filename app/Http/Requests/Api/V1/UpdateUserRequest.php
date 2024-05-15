<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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

        if($method == "PUT"){
            return [
                'name' => ['required'],
                'email' => ['required', 'email'],
                'userRoles' => ['require'],
            ];
        }else{
            return [
                'name' => ['sometimes'],
                'email' => ['sometimes', 'email'],
                'userRoles' => ['sometimes'],
            ];
        }
    }

    protected function prepareForValidation(){
        if($this->notifyToken){
            $this->merge([
                'user_roles' => $this->userRoles
            ]);
        }
    }
}
