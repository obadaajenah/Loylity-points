<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBundleRequest extends FormRequest
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
            'name' => ['required' , 'string'],
            'price' => ['required' , 'numeric'],
            'bonus' => ['numeric'],
            'gems' => ['numeric'],
            'expiration_period' => ['numeric'],
            'golden_offers_number' => ['numeric'],
            'silver_offers_number' => ['numeric'],
            'bronze_offers_number' => ['numeric'],
            'new_offers_number' => ['numeric']
        ];
    }

    public function massages(){
        return [];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json($validator->errors()),422);
    }
}
