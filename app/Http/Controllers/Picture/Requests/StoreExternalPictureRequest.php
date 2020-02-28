<?php

namespace App\Http\Controllers\Picture\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExternalPictureRequest extends FormRequest
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
     * @return array
     * @throws
     */
    public function rules()
    {
        return  [
            //'url' => ['required','url','regex:/(http|https):\/\/(www\.)?[\w-_\.]+\.[a-zA-Z]+\/((([\w-_\/]+)\/)?[\w-_\.]+\.(png$|jpe?g$))/i'],
            'url' => ['required','url'],
        ];
    }

    public function attributes()
    {
        return [
            'url' => 'URL'
        ];
    }
}