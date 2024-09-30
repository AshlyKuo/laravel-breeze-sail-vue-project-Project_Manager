<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePictureRequest extends FormRequest
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
                'name' => ['required'],
                'url' => ['required'],
                'type' => ['required', Rule::in(['H', 'D', 'C', 'S', 'h', 'd', 'c', 's' ])]
            ];
        }else{
            return [
                'name' => ['sometimes'],
                'url' => ['sometimes'],
                'type' => ['sometimes', Rule::in(['H', 'D', 'C', 'S', 'h', 'd', 'c', 's' ])]
            ];
        }
    }
}
