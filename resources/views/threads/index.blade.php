@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($threads as $thread)
                    <div>
                        <h6 class="mb-0">
                            <a href="{{ $thread->path() }}">
                                <h4>{{ $thread->title }}</h4>
                            </a>
                        </h6>
                        <p class="mb-0 opacity-75">{{ $thread->body }}</p>
                        <hr>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
