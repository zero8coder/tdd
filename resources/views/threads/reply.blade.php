
<li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto" id="reply-{{ $reply->id }}">
        <div class="fw">
            <a href="{{ route('profile', $reply->owner->name) }}">
                {{ $reply->owner->name }}
            </a>
            回复于 {{ $reply->created_at->diffForHumans() }}
        </div>
    </div>
    <div class="badge bg-primary rounded-pill">
{{--        <favorite :reply="{{ $reply }}}"></favorite>--}}
    </div>
    @can('delete', $reply)
        <div class="badge bg-warning rounded-pill">
            <button class="btn btn-xs mr-1" @click="editing = true">Edit</button>
        </div>
        <div class="badge bg-danger rounded-pill">
            <form action="/replies/{{ $reply->id }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-danger">删除</button>
            </form>
        </div>
    @endcan
</li>

