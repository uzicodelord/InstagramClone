
@extends('layouts.app')

@section('content')
    @vite(['resources/sass/home.scss', 'resources/js/follow.js', 'resources/js/home.js', 'resources/js/fwmodals.js'])

    <div class="col-6">
        <div class="user-profile-info d-flex align-items-start gap-4">
            <div class="profile-picture-container">
                <img src="{{ asset(Storage::url($user->profile_picture)) }}" alt="{{ $user->name }}'s Profile Picture" class="rounded-circle">
            </div>
            <div class="d-flex flex-column">
                <div class="d-flex align-items-center justify-content-center gap-5">
                    <div>
                    </div>
                    <h3 class="mb-0">{{ $user->name }}</h3>
                    <div class="d-flex align-items-center">
                        @if(Auth::user()->id == $user->id)
                                <button class="btn btn-primary unfwbutton" id="edit-profile-btn">Edit Profile</button>
                        @else
                                @endif
                        @if(auth()->check() && auth()->user()->id !== $user->id)

                            @if(auth()->user()->isFollowing($user))
                                <form action="{{ route('unfollow', $user) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn unfwbutton">Following <i style="font-size: 12px;" class="mdi mdi-check"></i></button>
                                </form>
                            @else
                                <form action="{{ route('follow', $user) }}" method="post">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary fwbutton">Follow</button>
                                </form>
                                @endif
                                <a href="{{ route('chats.index', ['receiver_id' => $user->id]) }}" class="userhover text-white d-flex align-items-center">
                                &nbsp<button type="submit" class="btn btn-primary unfwbutton">Message</button>
                                </a>
                            @endif
                    </div>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-sm-5 mt-2" style="padding-top: 10px;">
                    <span class="" style="font-size: 14px"><b>{{ $user->posts->count() }}</b> {{ Str::plural('post', $user->posts->count()) }}</span>
                    <a class="userhover" id="followers-btn" style="font-size: 14px;cursor: pointer"><b>{{ $user->followersCount() }}</b> {{ Str::plural('follower', $user->followersCount()) }}</a>
                    <a class="userhover" id="following-btn" style="font-size: 14px;cursor: pointer;"><b>{{ $user->followingCount() }}</b> {{ Str::plural('following', $user->followingCount()) }}</a>
                </div>
                <span style="padding-top: 10px;font-size: 14px;">{{ $user->bio }}</span>
            </div>
        </div>
            <hr>
        <div class="post-grid">
            @if($user->is_private && !auth()->user()->isFollowing($user) && $user->id !== auth()->id())
                <div class="container" style="border: 1px solid #737373;padding: 50px;">
                <div class="text-center">
                    <p>This Account is Private</p>
                    <p>Follow to see their photos and videos.</p>

                </div>
                </div>
            @else
                @foreach($user->posts->sortByDesc('created_at') as $post)
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
                @endforeach
            @endif
        </div>
    </div>

    <div id="followingmodal" class="modal">
        <div class="modal-dialog" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalLabel">Followings</h5>
                    <button style="background-color: black;border: none" type="button" class="followingclose" data-dismiss="modal" aria-label="Close">
                        <i class="mdi mdi-close" style="color: #fff;font-size: 20px;"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="following">
                        <ul>
                            @foreach($followings as $following)
                                <a href="{{ route('profiles.show', $following->name) }}" class="userhover">
                                    <div class="profile-picture-post-comment d-flex gap-2 justify-content-center">
                                        <img src="{{ asset(Storage::url($following->profile_picture)) }}" alt="{{ $following->name }}'s Profile Picture" class="rounded-circle">
                                        <h6 class="mb-2" style="padding-top: 5px;">{{ $following->name }}</h6>
                                    </div>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="followersmodal" class="modal">
        <div class="modal-dialog" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalLabel">Followers</h5>
                    <button style="background-color: black;border: none" type="button" class="followersclose" data-dismiss="modal" aria-label="Close">
                        <i class="mdi mdi-close" style="color: #fff;font-size: 20px;"></i>
                    </button>
                </div>
                <div class="modal-body">
                            @foreach($followers as $follower)
                                <a href="{{ route('profiles.show', $follower->name) }}" class="userhover">
                                    <div class="profile-picture-post-comment d-flex gap-2 justify-content-center">
                                        <img src="{{ asset(Storage::url($follower->profile_picture)) }}" alt="{{ $follower->name }}'s Profile Picture" class="rounded-circle">
                                        <h6 class="mb-2" style="padding-top: 5px;">{{ $follower->name }}</h6>
                                    </div>
                                </a>
                            @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-2"></div>
    <div id="edit-profile-modal" class="modal">
        <div class="modal-dialog" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalLabel">Edit Profile</h5>
                    <button style="background-color: black;border: none" type="button" class="editprofileclose" data-dismiss="modal" aria-label="Close">
                        <i class="mdi mdi-close" style="color: #fff;font-size: 20px;"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('profiles.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Username</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control comment @error('name') is-invalid @enderror" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control comment @error('email') is-invalid @enderror" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea style="resize: none;" name="bio" id="bio" class="form-control comment @error('bio') is-invalid @enderror">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="is_private">Make profile private</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_private" name="is_private" {{ $user->is_private ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_private">Only allow followers to see my posts</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="profile_picture">Profile Picture</label>
                            <input type="file" name="profile_picture" id="profile_picture" class="custom-file-input @error('profile_picture') is-invalid @enderror">
                            @error('profile_picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
