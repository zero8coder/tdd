@extends('layouts.app')

@section('content')
    <div class="md:container md:mx-auto">
        <div class="space-y-4 p-2">
            <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-8">

                <form method="post" action="/threads">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label class="block text-sm font-semibold leading-6 text-gray-900">频道</label>
                        <select name="channel_id" class="form-select text-gray-900 shadow-sm" aria-label="Default select example" required>
                            <option selected>选择一个频道</option>
                            @foreach ( $channels as $channel)
                                <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-semibold leading-6 text-gray-900">标题</label>
                        <input type="text" class="form-control text-gray-900 shadow-sm" id="title" name="title"
                               value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-semibold leading-6 text-gray-900">内容</label>
                        <textarea name="body" id="body" class="form-control text-gray-900 shadow-sm" rows="8"
                                  required>{{ old('body') }}</textarea>
                    </div>
                    <div class="mt-10">
                        <button type="submit"
                                class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            发布
                        </button>
                    </div>
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
@endsection
