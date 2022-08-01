<?php

declare(strict_types=1);

namespace App\Http\Requests\Messagerie;


use Gate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateConversationRequest.
 */
class UpdateConversationRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->route('conversation'));
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
        ];
    }
}
