<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $company = $this->route('company');
        if (Auth::user()->id !== $company->user_id) {
            return false;
        }
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
            'name' => 'required|string|max:255',
            // 'user_id' => 'exists:users,id',
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