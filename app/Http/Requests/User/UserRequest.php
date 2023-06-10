<?php

namespace App\Http\Requests\User;

use App\Enums\GeneralStatusEnum;
use App\Enums\RolesEnum;
use App\Traits\ApiResponser;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\NotIn;

class UserRequest extends FormRequest
{
    use ApiResponser;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'region_id'     =>      ['required', 'integer', 'exists:regions,id'],
            'commune_id'    =>      ['required', 'integer', 'exists:communes,id'],
            'dni'           =>      ['required', 'string', 'max:45'],
            'name'          =>      ['required', 'string', 'max:45'],
            'last_name'     =>      ['required', 'string', 'max:45'],
            'address'       =>      ['nullable', 'string', 'max:255'],
            'email'         =>      ['required', 'string', 'max:120', 'email', isset($this->user->id) ? 'unique:users,email,' . $this->user->id : 'unique:users'],
            'password'      =>      ['required', 'min:6'],
            'status'        =>      [
                'nullable',
                new In([
                    GeneralStatusEnum::Active,
                    GeneralStatusEnum::Inactive,
                ])
            ],
            'role'          =>      [
                'required',
                new In([
                    RolesEnum::Administrator,
                    RolesEnum::Customer
                ])
            ]
        ];

        if (!auth()->user()->hasRole( RolesEnum::Administrator)) {
            $rules['role'][] = new NotIn([
                RolesEnum::Administrator,
            ]);
        }

        return $rules;
    }

    /**
     * @param Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator): mixed
    {
        throw new HttpResponseException($this->errorResponse($validator->errors(), 422));
    }
}
