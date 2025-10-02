<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'password' => ['string', 'min:8', 'confirmed'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
