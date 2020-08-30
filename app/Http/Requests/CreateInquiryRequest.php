<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInquiryRequest extends FormRequest
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
            'name'    => ['required', 'max:50'],
            'email'   => ['required', 'max:50', 'email'],
            'phone'   => ['required', 'max:15', 'min:10'],
            'message' => ['required', 'max:500'],
        ];
    }
}
