<?php

namespace App\Http\Requests;

use App\Rules\MaxThreePosts;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "title" => "required|unique:posts|min:3",
            "description" => "required|min:10",
            "image" => "required|image|mimes:jpg,jpeg,png|max:2048",
            new MaxThreePosts
            // "author" => "required|exists:users,id"
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
