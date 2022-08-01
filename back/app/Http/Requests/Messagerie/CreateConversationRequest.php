<?php

declare(strict_types=1);

namespace App\Http\Requests\Messagerie;

use App\Models\Conversation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * Class CreateConversationRequest.
 */
class CreateConversationRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Conversation::class);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|max:255',
          // 'participants' => 'required|array|each|exists:users,id',
        ];
    }
}
