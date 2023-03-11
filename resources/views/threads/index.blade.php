@extends('layouts.app')

@section('content')
    <ol class="list-group">
        @foreach($threads as $thread)

            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold"><a href="{{ $thread->path() }}">{{ $thread->title }}</a></div>
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
@endsection
