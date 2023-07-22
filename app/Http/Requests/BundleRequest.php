<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BundleRequest extends FormRequest
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
            'golden_offers_number' => ['numeric','min:0'],
            'silver_offers_number' => ['numeric','min:0'],
            'bronze_offers_number' => ['numeric','min:0'],
            'new_offers_number' => ['numeric','min:0']
        ];
    }

    public function massages(){
        return [];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json($validator->errors()),422);
    }
}

