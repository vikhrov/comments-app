@foreach($replies as $reply)
    <div class="card text-center mb-3 ms-5">
        <div class="card-header">
            {{$reply->user_name}}
        </div>
        <div class="card-body">
            @if ($reply && $reply->text)
                <p class="card-text">{!! html_entity_decode($reply->text->text) !!}</p>
            @else
                <p class="card-text">Нет текста для этого комментария</p>
            @endif
        </div>

        <form method="get" action="{{ route('comments.create') }}">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $reply->id }}">
            <button type="submit" class="btn btn-link text-end">reply</button>
        </form>

        <div class="card-footer text-body-secondary">
            {{$reply->created_at->diffForHumans()}}
        </div>
        @if($reply->replies->count() > 0)
            <button class="show-replies-btn btn-primary text-right text-sm m-2 text-primary" data-parent="{{ $reply->id }}">Show replies</button>
        @endif
        <div class="replies-container" id="replies-container-{{ $reply->id }}"></div>
    </div>
@endforeach


