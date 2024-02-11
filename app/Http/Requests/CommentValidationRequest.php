<?php

namespace App\Http\Requests;

use App\Dto\CommentDto;
use Illuminate\Foundation\Http\FormRequest;

class CommentValidationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_name' => 'required|string|min:2|max:256',
            'email' => 'required|email|string|max:256',
            'home_page' => 'nullable|string|url|max:256',
            'text' => ['required', 'string', 'min:2', 'max:2000', 'regex:/^(<a\s[^>]*>|<\/a>|<code>|<\/code>|<i>|<\/i>|<strong>|<\/strong>|[^<>\n])*$/'],
            'parent_id' => 'nullable|numeric',
            'captcha' => 'required|captcha',
            'media' => 'nullable|file|max:1024|mimes:jpeg,png,gif,txt',
        ];
    }

    public function getData(): CommentDto
    {
        return new CommentDto(
            user_name: $this->validated('user_name'),
            email: $this->validated('email'),
            text: $this->validated('text'),
            parent_id: $this->validated('parent_id'),
            home_page: $this->validated('home_page'),
            media: $this->file('media')
        );
    }
}
