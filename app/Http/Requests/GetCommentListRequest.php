<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetCommentListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'column' => ['bail', 'sometimes', 'string', Rule::in(['user_name', 'email', 'created_at'])],
            'direction' => ['bail', 'sometimes', 'string', Rule::in(['asc', 'desc'])],
        ];
    }

    public function getColumn(): string
    {
        return $this->validated('column') ?? 'created_at';
    }

    public function getDirection(): string
    {
        return $this->validated('direction') ?? 'desc';
    }


}
