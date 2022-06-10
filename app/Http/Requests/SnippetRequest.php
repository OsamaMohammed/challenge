<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SnippetRequest extends FormRequest
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
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'desc' => 'required|string|max:255',
            'code' => 'required|string|max:' . (16 * 1024 * 1024), // 16 MB
        ];
    }
}
