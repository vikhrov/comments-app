@foreach($replies as $reply)
    <div class="card text-center mb-3 ms-5">
        <div class="card-header">
            {{$reply->user_name}}
        </div>
        <div class="card-body">
            @if ($reply && $reply->text)
                <p class="card-text">{{ $reply->text->text }}</p>
            @else
                <p class="card-text">Нет текста для этого комментария</p>
            @endif
        </div>

        <form method="get" action="{{ route('comments.create') }}">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $reply->id }}">
            <button type="submit" class="btn btn-link">Ответить</button>
        </form>

        <div class="card-footer text-body-secondary">
            {{$reply->created_at->diffForHumans()}}
        </div>

        <button class="show-replies-btn" data-parent="{{ $reply->id }}">Показать ответы</button>
        <div class="replies-container" id="replies-container-{{ $reply->id }}"></div>
    </div>
@endforeach


