@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div >
                    <div>
                        {{ $thread->title }}
                    </div>

                    <div>
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
