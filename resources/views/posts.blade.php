@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Posts Page</div>
                <div class="card-body">
                    <form action="{{ route('posts.search') }}" method="get">
                       <div class="form-group">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search" />
                        </div>
                       <div class="form-group">
                            <button class="btn btn-success">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            
            @foreach($posts as $post)
                <br/>    
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>    
                    </div>
                    <div class="card-body">
                        {{ $post->body }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
