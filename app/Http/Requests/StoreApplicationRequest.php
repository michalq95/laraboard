<?php

namespace App\Http\Requests;

use App\Rules\UniqueApplication;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'application' => 'required|string|max:2000',
            'resume' => 'nullable',
            "offer_id" => ['required', 'exists:offers,id', new UniqueApplication],
            "status" => 'numeric'
            // "user_id" => 'required',
        ];
    }
}