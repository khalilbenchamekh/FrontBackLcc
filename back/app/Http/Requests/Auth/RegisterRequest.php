<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'firstname' => ['required_if:step,0|string|max:255'],
            'lastname' => ['required_if:step,0|string|max:255'],
            'gender' => ['nullable|in:female,male'],
            'birthdate' =>
                'nullable|date:Y-m-d|before:'.now()->subYear(10)->format('Y-m-d'),
            'address' => ['nullable|string|max:510'],
            'role' => ['required_if:step,1|in:roles'],
            'username' => ['unique:users' ,'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
