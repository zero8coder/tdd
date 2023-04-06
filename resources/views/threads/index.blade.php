@extends('layouts.app')

@section('content')
    <div class="md:container md:mx-auto">
        @include ('threads._list')
        <div class="space-y-4 p-2">
            <div class="space-y-4 max-w-md mx-auto overflow-hidden md:max-w-2xl p-8">
            {{ $threads->render() }}
            </div>
        </div>
    </div>
@endsection
