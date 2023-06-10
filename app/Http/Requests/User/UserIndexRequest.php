<?php

namespace App\Http\Requests\User;

use App\Enums\GeneralStatusEnum;
use App\Enums\RolesEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

class UserIndexRequest extends FormRequest
{
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
        return [
            'status' => [
                'nullable',
                new In([
                    GeneralStatusEnum::Active,
                    GeneralStatusEnum::Inactive,
                ])
            ],
            'per_page' => ['nullable', 'integer'],
            'role' => [
                'nullable',
                'string',
                new In([
                    RolesEnum::Administrator,
                    RolesEnum::Customer
                ])
            ],
        ];
    }

    /**
     * @return void
     */
    public function getStatus(): void
    {
        $this->input('status', GeneralStatusEnum::Active);
    }

    /**
     * @return void
     */
    public function getPerPage(): void
    {
        $this->input('per_page', 10);
    }

    /**
     * @return void
     */
    public function getRole(): void
    {
        $this->input('role');
    }
}
