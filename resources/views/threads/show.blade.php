@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div>
                    <div>
                        <a href="#">{{ $thread->creator->name }}</a> 发表了：
                        {{ $thread->title }}
                    </div>

                    <div>
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach ($thread->replies as $reply)
                   @include('threads.reply')
                    <hr>
                @endforeach
            </div>
        </div>

        @if( auth()->check())
            {{-- 已登录用户能看 --}}
            <div class="row">
                <div class="mb-3">
                    <form method="post" action="{{ $thread->path() . '/replies' }}">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <textarea class="form-control" name="body" id="body" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mb-3">提交</button>
                    </form>
                </div>
            </div>
        @else
            <p class="text-center">请先<a href="{{ route('login') }}">登录</a>，然后再发表回复 </p>
        @endif
    </div>
@endsection
