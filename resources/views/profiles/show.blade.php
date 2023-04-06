@extends('layouts.app')

@section('content')
    <div class="md:container md:mx-auto">
    <avatar-form :user="{{ $profileUser }}"></avatar-form>

    @foreach($activities as $date => $activity)
            @foreach($activity as $record)
                @if (view()->exists("profiles.activities.{$record->type}"))
                    @include("profiles.activities.{$record->type}", ['activity'  => $record, 'date' => $date])
                @endif
            @endforeach
        @endforeach
    </div>
@endsection
