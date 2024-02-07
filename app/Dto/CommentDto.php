<?php

namespace App\Dto;

use Illuminate\Http\UploadedFile;

class CommentDto
{
    public function __construct(
        private readonly string $user_name,
        private readonly string $email,
        private readonly string $text,
        private readonly ?int $parent_id = null,
        private readonly ?string $home_page = null,
        private readonly ?UploadedFile $media = null,
        private ?int $comment_id = null
    ) {
    }

    public function setCommentId(int $commentId): void
    {
        $this->comment_id = $commentId;
    }

    public function getMedia(): ?UploadedFile
    {
        return $this->media;
    }

    public function toCommentArray(): array
    {
        return [
            'user_name' => $this->user_name,
            'email' => $this->email,
            'home_page' => $this->home_page,
            'parent_id' => $this->parent_id,
        ];
    }

    public function toTextArray(): array
    {
        return [
            'text' => $this->text,
            'comment_id' => $this->comment_id,
        ];
    }
}
