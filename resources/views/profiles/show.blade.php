@extends('layouts.app')

@section('content')
    <div class="md:container md:mx-auto">
        <div class="space-y-4 p-2">
            <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-8">
            {{ $profileUser->name }}<small>注册于{{ $profileUser->created_at->diffForHumans() }}</small>
            </div>
        </div>
        @foreach($activities as $date => $activity)
            @foreach($activity as $record)
                @if (view()->exists("profiles.activities.{$record->type}"))
                    @include("profiles.activities.{$record->type}", ['activity'  => $record, 'date' => $date])
                @endif
            @endforeach
        @endforeach
    </div>
@endsection
