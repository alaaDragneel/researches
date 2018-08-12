@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h5> {{ $post->title }} </h5>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="mr-1">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                        <archive-button post-id="{{ $post->id }}" is-archive="{{ $post->isArchive() }}"></archive-button>
                    </div>
                </div>
                <div class="card-body">
                    {{ $post->body }}
                </div>
            </div>

            <comments-manager :user="{{ auth()->user() }}" :post="{{ $post->id }}"></comments-manager>
        </div>
    </div>
</div>
@endsection
