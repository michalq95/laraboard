<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;

class UpdateOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // $offer = $this->route("offer");
        // return Gate::allows("update-offer", $offer);
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
            'status' => 'required|in:draft,active,inactive',
            'description' => 'string',
            'bracket_low' => 'integer|required_with:bracket_high',
            'bracket_high' => 'integer|required_with:bracket_low|gte:bracket_low',
            'currency' => 'string|required_with:bracket_low',
            'icon' => 'string|nullable',
            // 'expire_date' => 'nullable|date',
            'tags' => "nullable|string"
        ];
    }
}