@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Creat Post</div>
                <div class="card-body">
                    <form action="{{ route('posts.store') }}" method="post">
                        @csrf
                       <div class="form-group">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" />
                        </div>
                       <div class="form-group">
                            <textarea class="form-control" id="body" name="body" placeholder="Body" rows="10" ></textarea>
                        </div>
                       <div class="form-group">
                            <button class="btn btn-success">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
