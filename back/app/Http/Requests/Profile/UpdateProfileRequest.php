<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        $user = request()->user();

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'firstname' => 'string', 'max:255',
            'lastname' => 'string', 'max:255',
            'email' => 'email',
            'name' =>'string', 'max:255',
            'gender' => 'nullable', 'in:female,male',
            'birthdate' =>
                'nullable', 'date:Y-m-d', 'before:' . now()->subYears(10)->format('Y-m-d'),
            'address' => ['nullable', 'string', 'max:510'],
            'username' => ['unique:users', 'string', 'max:255'],
            'avatar.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
