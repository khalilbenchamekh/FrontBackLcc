<?php

declare(strict_types=1);

namespace App\Http\Requests\Messagerie;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * Class UpdateMessageRequest.
 */
class UpdateMessageRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->route('message'));
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'content' => ['required', 'max:255'],
        ];
    }
}
