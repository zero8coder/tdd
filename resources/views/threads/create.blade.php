@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <h2>发布帖子</h2>

                <div class="">
                    <form method="post" action="/threads">
                        {{ csrf_field() }}

                        <div class="mb-3">
                            <label class="form-label">频道</label>
                            <select name="channel_id" class="form-select" aria-label="Default select example" required>
                            <option selected>选择一个频道</option>
                            @foreach ( \App\Models\Channel::all() as $channel)
                            <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                            @endforeach
                        </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">标题</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">内容</label>
                            <textarea name="body" id="body" class="form-control" rows="8" required>{{ old('body') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">发布</button>
                    </form>
                </div>

                @if(count($errors))
                    <ul class="list-group">
                        @foreach ($errors->all() as $error)
                            <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
    </div>
@endsection
