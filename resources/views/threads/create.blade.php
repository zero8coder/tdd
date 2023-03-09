@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="">
                    <div class="">发布帖子</div>

                    <div class="">
                        <form method="post" action="/threads">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="title">标题</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>

                            <div class="form-group">
                                <label for="body">内容</label>
                                <textarea name="body" id="body" class="form-control" rows="8"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">发布</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
