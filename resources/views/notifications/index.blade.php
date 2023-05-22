@extends('layouts.app')

@section('content')
    <div class="col-8">
    <h1>Notifications</h1>
    <ul>
        @foreach($notifications as $notification)
            <br>
            <div style="display: flex; align-items: center;">
                <a href="{{ route('profiles.show', $notification->data['user_name']) }}" class="userhover">
                    <div class="profile-picture-post-comment d-flex gap-2 justify-content-start">
                        <img src="{{ asset(Storage::url($notification->data['user_profile_picture'])) }}" alt="{{ $notification->data['user_name'] }}'s Profile Picture" class="rounded-circle">
                    </div>
                </a>
                <span style="padding: 5px;">{{ $notification->data['message'] }}</span>
                <div class="profile-picture-post-comment">
                    <a href="{{ route('posts.show', $notification->data['post_id']) }}">
                        <img src="{{ asset(Storage::url($notification->data['post_image'])) }}">
                    </a>
                </div>
            </div>
        @endforeach
    </ul>
    </div>
@endsection
