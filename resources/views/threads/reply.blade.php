<div>
    <div>
        <a href="#">
            {{ $reply->owner->name }}
        </a>
        回复于 {{ $reply->created_at->diffForHumans() }}
    </div>

    <div>
        {{ $reply->body }}
    </div>
</div>
