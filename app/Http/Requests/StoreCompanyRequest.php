<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreCompanyRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        // dd($this->user());
        $this->merge(['user_id' => $this->user()->id]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'user_id' => 'exists:users,id',
            'status' => 'required|in:draft,active,inactive',
            'email' => 'required|string|email',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'loc_x' => 'nullable|numeric',
            'loc_y' => 'nullable|numeric',
            "image" => 'nullable|string'

        ];
    }
}
