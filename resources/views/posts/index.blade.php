
@extends('layouts.app')

@section('content')
    @vite(['resources/sass/home.scss', 'resources/js/follow.js', 'resources/js/home.js'])

    <div class="col-9">
        <div class="post-grid" >

            @foreach($posts as $post)
                @if(!$post->user->is_private)
                <div class="post-container">
                    <a href="{{ route('posts.show', $post->id) }}">
                        <img src="{{ Storage::url($post->image) }}" class="gridimage"
                             data-comments="{{ $post->comments->count() }}" data-likes="{{ $post->likes->count() }}">
                    </a>
                    <div class="count-overlay">
                        <div class="count-text">
                            <span class="likes-count"><a class="nobac" href="{{ route('posts.show', $post->id) }}"><i class="mdi mdi-heart"></i> {{ $post->likes->count() }}</a></span>
                            <span class="comments-count"><a class="nobac" href="{{ route('posts.show', $post->id) }}"><i class="mdi mdi-chat"></i> {{ $post->comments->count() }}</a></span>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        <div  class="post-grid d-flex justify-content-center align-items-center flex-wrap">
            {!! $posts->links() !!}
        </div>
    </div>
@endsection
