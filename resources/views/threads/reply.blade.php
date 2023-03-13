<li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto">
        <div class="fw">
            <a href="#">
                {{ $reply->owner->name }}
            </a>
            回复于 {{ $reply->created_at->diffForHumans() }}
        </div>
        {{ $reply->body }}
    </div>
    <div class="badge bg-primary rounded-pill">
        <form method="POST" action="/replies/{{ $reply->id }}/favorites">
            {{ csrf_field() }}
            <button
                class="btn btn-primary"
                type="submit" {{$reply->isFavorited() ? 'disabled' : ''}}
            >{{ $reply->favorites()->count() }}点赞</button>
        </form>
    </div>
</li>


