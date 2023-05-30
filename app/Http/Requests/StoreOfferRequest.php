<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
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
        $this->merge([
            'user_id' => $this->user()->id
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'company_id' => 'exists:companies,id',
            'status' => 'required',
            'description' => 'string',
            'bracket_low' => 'integer',
            'bracket_high' => 'integer',
            'expire_date' => 'nullable|date',
            'tags' => "nullable|string"
        ];
    }
}