@extends('layouts.app')

@section('content')
    <thread-view :thread = "{{ $thread }}" :replies = "{{ $replies }}"></thread-view>
    <replies :replies="{{ $replies }}"></replies>
@endsection
