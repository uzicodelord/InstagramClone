@extends('layouts.app')

@section('content')
    @vite(['resources/sass/home.scss', 'resources/js/home.js', 'resources/js/search.js'])
        <div class="col-md">
            @foreach ($posts as $post)
                <div class="card mb-3 p-0" data-post-id="{{ $post->id }}">
                    <div class="card-header">
                        <a href="{{ route('profiles.show', $post->user->name) }}" class="userhover">
                            <div class="profile-info-wrapper d-flex align-items-center justify-content-start">
                                <div class="profile-picture-post-comment">
                                    <img src="{{ asset(Storage::url($post->user->profile_picture)) }}" alt="{{ $user->name }}'s Profile Picture" class="rounded-circle">
                                </div>
                                <div class="profile-info">
                                    <span class="profile-name">{{ $post->user->name }}</span>

                                    <small class="text-muted">•  {{ $post->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="home-post-image">
                        <img src="{{ Storage::url($post->image) }}" class="post-image" alt="Post image">
                        </div>
                        <br>
                        <a class="like-link userhover" href="#" data-post-id="{{ $post->id }}">
                            <i class="like-icon mdi mdi-heart-outline" style="font-size: 30px;"></i>
                        </a>
                        <a href="{{ route('posts.show', $post->id) }}" class="userhover">
                            <i id="like-icon" class="mdi mdi-chat-outline" style="font-size: 30px;"></i>
                        </a>
                        <div>
                            <p id="like-count" class="card-text like-count">{{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}</p>
                            <p><a class="userhover" href="{{ route('profiles.show', $post->user->name) }}">{{ $post->user->name }}</a><span style="padding-left: 4px;">{{ $post->caption }}</span></p>
                        </div>
                    </div>
                    <div id="comment-list" class="card-footer">
                        @foreach($post->comments->take(3) as $comment)
                            <div class="card">
                                <div class="card-body card-body-comment">
                                        <p><a class="userhover" href="{{ route('profiles.show', $post->user->name) }}">{{ $comment->user->name }}</a><span style="padding-left: 4px;">{{ $comment->content }}</span></p>
                                </div>
                            </div>
                        @endforeach
                        <div class="card-body" style="font-size: 14px;">
                            @if($post->comments->count() > 3)
                                <a href="{{ route('posts.show', $post->id) }}" class="text-muted userhover ">View all {{ $post->comments->count() }} comments</a>
                            @endif
                        </div>
                    </div>
                </div>
                <form id="comment-form" data-post-id="{{ $post->id }}">
                    @csrf
                    <div class="form-group">
                        <div class="d-flex">
                            <input name="content" id="content" placeholder="Add a comment" class="form-control comment" style="width: 90%;" autocomplete="off">
                            <button type="submit" class="btn btn-primary ms-2 comment-button" style="display: none">Post</button>
                        </div>
                    </div>
                </form>
                <hr style="margin-top: 0;">
            @endforeach
        </div>
        <div class="col-md">
            <div class="user-info d-flex align-items-center gap-2">
                <div class="profile-picture-home">
                    <a class="userhover" href="{{ route('profiles.show', $user->name) }}">
                        <img src="{{ asset(Storage::url($user->profile_picture)) }}" alt="{{ $user->name }}'s Profile Picture" class="rounded-circle mr-2">
                    </a>
                </div>
                <a class="userhover" href="{{ route('profiles.show', $user->name) }}">
                    <span style="font-size: 14px;">{{ $user->name }}</span>
                </a>
            </div>
            <br>
            <div class="card-body border-1">
                <p>Suggested for you</p>
                    <div class="card-body border-1">
                        @foreach($suggested as $suguser)
                            @if(!$suguser->followers->contains(Auth::user()))
                            @if($suguser->id != Auth::id())
                                <br>
                                <div class="card">
                                    <div class="card-body d-flex align-items-center gap-2">
                                        <div class="profile-picture-home">
                                            <img src="{{ asset(Storage::url($suguser->profile_picture)) }}" alt="{{ $suguser->name }}'s Profile Picture" class="rounded-circle mr-2">
                                        </div>
                                        <a class="userhover" href="{{ route('profiles.show', $suguser->name) }}">
                                            <span style="font-size: 14px;">{{ $suguser->name }}</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @endif
                        @endforeach


                    </div>

        </div>
        </div>
@endsection
