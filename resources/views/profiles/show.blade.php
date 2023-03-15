@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="">
            {{ $profileUser->name }}<small>注册于{{ $profileUser->created_at->diffForHumans() }}</small>
        </div>
    </div>
    <ol class="list-group">
        @foreach($threads as $thread)

            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold"><a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>发表{{ $thread->title }}<span class="right">{{ $thread->created_at->diffForHumans() }}</span></div>
                    {{ $thread->body }}
                </div>
                @if (!empty($thread->replies_count))
                    <span class="badge bg-primary rounded-pill">
                        {{$thread->replies_count}}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
    {{ $threads->links() }}
@endsection
