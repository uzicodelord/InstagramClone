@extends('layouts.app')

@section('content')
    @vite(['resources/sass/home.scss', 'resources/js/comment-like.js'])
        <div class="col-md">
            <div class="post-picture">
            <img src="{{ Storage::url($post->image) }}" alt="Post image">
            </div>
        </div>
        <div class="col-md">
            <div class="card" data-post-id="{{ $post->id }}">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('profiles.show', $post->user->name) }}" class="userhover">
                        <div class="profile-picture-post-comment d-flex gap-2 justify-content-center">
                        <img src="{{ asset(Storage::url($post->user->profile_picture)) }}" alt="{{ $user->name }}'s Profile Picture" class="rounded-circle">
                            <h6 class="mb-2" style="padding-top: 5px;">{{ $post->user->name }}</h6>
                        </div>
                    </a>
                    @if(Auth::check() && Auth::user()->id === $user->id)
                        <div class="dropdown">
                              <span class="btn dropdown-toggle border-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i style="font-size: 24px;color: #fff;" class="mdi mdi-dots-horizontal"></i>
                              </span>
                            <div class="dropdown-menu dropdown-menu-right bg-black" aria-labelledby="dropdownMenuButton">
                                <button type="button" class="dropdown-item userhover" id="open-edit-modal-btn" style="color: #fff;">Edit Post</button>
                                <button type="button" class="dropdown-item userhover text-danger" id="open-delete-modal-btn">Delete Post</button>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- MODALS -->
                <div id="edit-post-modal" class="modal">
                    <div class="modal-dialog" style="max-width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createPostModalLabel">Edit Post</h5>
                                <button style="background-color: black;border: none" type="button" class="editclose" data-dismiss="modal" aria-label="Close">
                                    <i class="mdi mdi-close" style="color: #fff;font-size: 20px;"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('posts.update', $post->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="post-caption" class="col-form-label">Caption:</label>
                                        <textarea style="resize: none;" class="form-control comment" id="post-caption" name="caption">{{ old('caption', $post->caption) }}</textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary comment-button">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="delete-post-modal" class="modal">
                    <div class="modal-dialog" style="max-width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createPostModalLabel">Delete Post</h5>
                                <button style="background-color: black;border: none" type="button" class="deleteclose" data-dismiss="modal" aria-label="Close">
                                    <i class="mdi mdi-close" style="color: #fff;font-size: 20px;"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this post?</p>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MODALS -->
                <hr>
                <div class="card-footer">
                    <div class="d-flex align-items-start">
                        <a class="userhover" href="{{ route('profiles.show', $user->name) }}">
                            <div class="profile-picture-post-comment">
                            <img src="{{ asset(Storage::url($user->profile_picture)) }}" class="rounded-circle">
                            </div>
                        </a>
                        <div class="card-body card-body-comment ml-2">
                            <p>
                                <a class="userhover" href="{{ route('profiles.show', $user->name) }}">
                                    {{ $user->name }}
                                </a>
                                <span style="font-size: 10px;padding-left: 4px;">{{ $post->caption }}</span>
                            </p>
                            <p class="text-muted" style="font-size: 10px;">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                        <div class="col-md">
                            <div id="comment-list" style="overflow-y: scroll; height: 450px;">
                                @foreach($post->comments->sortByDesc(function($comment) {
                                    return $comment->likes->count();
                                }) as $comment)
                                    <div class="card" style="padding-top: 10px;">
                                        <div class="d-flex align-items-start">
                                            <a class="userhover" href="{{ route('profiles.show', $comment->user->name) }}">
                                                <div class="profile-picture-post-comment">
                                                <img src="{{ asset(Storage::url($comment->user->profile_picture)) }}" class="rounded-circle">
                                                </div>
                                            </a>
                                            <div class="card-body card-body-comment ml-2">
                                                <p>
                                                    <a class="userhover" href="{{ route('profiles.show', $comment->user->name) }}">
                                                        {{ $comment->user->name }}
                                                    </a>
                                                    <span style="font-size: 10px;padding-left: 4px;">{{ $comment->content }}</span>
                                                </p>
                                                <p class="text-muted" style="font-size: 10px;">{{ $comment->created_at->diffForHumans() }}
                                                    <a href="#" class="like-comment-links userhover iconhover" data-comment-id="{{ $comment->id }}">
                                                        <i style="font-size: 12px;float: right" class="mdi mdi-heart liked-comment-icons"></i>
                                                    </a>
                                                    <br>
                                                    <span style="padding-left: 0;font-size: 11px;color: #fff;" class="ml-2 liked-comment-counts">{{ $comment->likes->count() }} {{ Str::plural('like', $comment->likes->count()) }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="">
                            <form id="comment-form" data-post-id="{{ $post->id }}">
                                @csrf
                                <div class="form-group">
                                    <a class="like-link userhover iconhover" href="#" data-post-id="{{ $post->id }}">
                                        <i class="like-icon mdi mdi-heart-outline" style="font-size: 30px;"></i>
                                    </a>
                                    <a class="userhover iconhover" href="#" data-post-id="{{ $post->id }}">
                                        <i class="mdi mdi-chat-outline" style="font-size: 30px;"></i>
                                    </a>
                                    <div>
                                        <p id="like-count" class="card-text like-count">{{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}</p>
                                    </div>
                                    <p class="text-muted">{{ $post->created_at->diffForHumans() }}</p>
                                    <hr>
                                    <div class="d-flex">
                                        <input name="content" id="content" placeholder="Add a comment" class="form-control comment" style="width: 90%;" autocomplete="off">
                                        <button type="submit" class="btn btn-primary ms-2 comment-button">Post</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
