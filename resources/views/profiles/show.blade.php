@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="">
            {{ $profileUser->name }}<small>注册于{{ $profileUser->created_at->diffForHumans() }}</small>
        </div>
        @foreach($activities as $date => $activity)
            <h3 class="page-header">{{ $date }}</h3>
            @foreach($activity as $record)
                @if (view()->exists("profiles.activities.{$record->type}"))
                    @include("profiles.activities.{$record->type}", ['activity'  => $record])
                @endif
            @endforeach
        @endforeach
    </div>
@endsection
