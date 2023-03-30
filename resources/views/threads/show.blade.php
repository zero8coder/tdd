@extends('layouts.app')

@section('content')
    <thread-view :thread = "{{ $thread }}" ></thread-view>
    <replies> </replies>
@endsection
