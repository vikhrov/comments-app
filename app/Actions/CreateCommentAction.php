<?php

namespace App\Actions;

use App\Dto\CommentDto;
use App\Exceptions\EntityCreateException;
use App\Models\Comment;
use App\Models\Text;
use DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Image;
use Log;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Throwable;

class CreateCommentAction
{
    /**
     * @throws EntityCreateException
     * @throws ValidationException
     */
    public function execute(CommentDto $dto): Comment
    {
        try {
            return DB::transaction(function () use ($dto): Comment {
                $comment = Comment::create($dto->toCommentArray());

                $dto->setCommentId($comment->id);

                $text = Text::create($dto->toTextArray());

                if ($uploadedFile = $dto->getMedia()) {

                    $media = match ($uploadedFile->getMimeType()) {
                        'image/jpeg',
                        'image/png',
                        'image/gif' => $this->saveImage($uploadedFile, $comment),
                        'text/plain' => $this->saveTextfile($uploadedFile, $comment),
                        default => throw ValidationException::withMessages([
                            'media' => __('validation.mime'),
                        ]),
                    };

                    $comment->setRelation('media', collect($media));
                }

                return $comment->setRelation('text', $text);
            });
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Fail create comment', ['exception' => $e]);
            throw new EntityCreateException();
        }
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    private function saveImage(UploadedFile $file, Comment $comment): Media
    {
        $image = Image::make($file->path());
        $image->fit(320, 240); // Обрезаем изображение до заданных размеров
        return $comment->addMediaFromStream($image->stream())
            ->toMediaCollection('comment_media');
    }

    /**
     * @throws ValidationException
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    private function saveTextFile(UploadedFile $file, Comment $comment): Media
    {
        if ($file->getSize() > 100 * 1024) {
            throw ValidationException::withMessages([
                'media' => 'The file may not be greater than 100 kilobytes.',
            ]);
        }

        return $comment->addMedia($file->path())
                ->toMediaCollection('comment_media');
    }
}
