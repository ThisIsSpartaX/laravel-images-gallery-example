<?php

namespace App\Http\Controllers\Picture\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePictureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws
     */
    public function rules(): array
    {
        return  [
            'picture' => 'required|image|mimes:jpg,jpeg,png',
        ];
    }

    public function attributes(): array
    {
        return [
            'picture' => 'Файл'
        ];
    }
}