<?php

declare(strict_types=1);

namespace App\Http\Requests\Messagerie;

use App\Models\Message;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * Class CreateMessageRequest.
 */
class CreateMessageRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Message::class);
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
