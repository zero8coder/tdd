@extends('layouts.app')

@section('content')
    <scan :appid = "{{ config('scout.algolia.id') }}" :appkey= "{{ config('scout.algolia.secret') }}"></scan>
@endsection
