<?php

namespace App\Http\Requests;

use App\Rules\CpfValidate;
use Illuminate\Foundation\Http\FormRequest;

class GetOfertasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $request = $this->all();
        if(!empty($request['cpf']))
        {
            $request['cpf'] = str_replace(['.','-'],['',''],$request['cpf']);
            $this->replace($request);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cpf' => ['required','digits:11', /*new CpfValidate()*/]
        ];
    }
    public function messages()
    {
        return [
            'cpf.digits' => 'CPF incorreto'
        ];
    }
    
}
