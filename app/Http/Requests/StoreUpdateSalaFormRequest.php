<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateSalaFormRequest extends FormRequest
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
        $rules = [
            'bloco' => [
                    'required',
                    'string',
                    'max:10',
                    'min:1',
                ],

            'nsala' => [
                    'required',
                    'integer',
            ],

            'qnt_maquinas'=> [
                    'required',
                    'integer',
            ],

            'hora'=> [
                    'required',
            ],
                
            'data'=> [
                    'required',
                    'date',
            ],
        ];


        return $rules;
    }
}
