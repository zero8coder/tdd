@extends('layouts.app')

@section('content')
    <div class="flex">
        <div class="md:w-3/4">
            <div class="md:container md:mx-auto">
                @include ('threads._list')
                <div class="space-y-4 p-2">
                    <div class="space-y-4 max-w-md mx-auto overflow-hidden md:max-w-2xl p-8">
                        {{ $threads->render() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="md:w-1/4">
            <div class="space-y-4 p-2">
            <div class="bg-white rounded-lg shadow-md">
                @foreach($trending as $thread)
                <div class="px-4 py-3 border-b border-gray-200">

                    <h2 class="text-lg font-medium text-gray-700"><a href="{{ url($thread->path) }}"> {{ $thread->title }}</a></h2>
                </div>
                @endforeach
            </div>
            </div>
        </div>
    </div>
@endsection
