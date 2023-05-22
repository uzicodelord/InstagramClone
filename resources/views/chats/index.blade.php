@extends('layouts.app')

@section('content')
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Users</div>
                <div class="card-body">
                    @foreach(Auth::user()->following as $user)
                        <div class="user-card mb-3">
                            <a href="{{ route('chats.index', ['receiver_id' => $user->id]) }}" class="userhover text-white d-flex align-items-center">
                                <div class="profile-picture-home mr-3">
                                    <img src="{{ asset(Storage::url($user->profile_picture)) }}" alt="{{ $user->name }}'s Profile Picture" class="rounded-circle">
                                </div>
                                <div class="profile-info">
                                    <span class="profile-name">{{ $user->name }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @if(request('receiver_id'))
                <div class="card chat-card">
                    <div class="card-body chat-body" id="chat-container">
                        @foreach($chats as $chat)
                            <div class="chat-message">
                                <div class="chat-message-meta">
                                    <img src="{{ asset(Storage::url($chat->sender->profile_picture)) }}" alt="">
                                    <strong>{{ $chat->sender->name }}</strong>
                                    <span>{{ $chat->created_at->diffForHumans()}}</span>
                                </div>
                                <div class="chat-message-content">{{ $chat->message }}</div>
                            </div>
                        @endforeach
                    </div>
                    <form id="chat-form" class="chat-form">
                        <div class="input-group">
                            <input type="hidden" name="receiver_id" value="{{ request('receiver_id') }}">
                            <input type="hidden" name="sender_name" value="{{ auth()->user()->name }}">
                            <input type="hidden" name="sender_profile_picture_url" value="{{ Storage::url(auth()->user()->profile_picture) }}">
                            <input type="text" id="message" name="message" placeholder="Type your message..." class="form-control comment">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
@endsection

    <style>
        .user-card {
            background-color: #000000;
            padding: 10px 15px;
            border-radius: 10px;
            transition: background-color 0.2s;
            border: 1px solid #fff;
        }

        .user-card:hover {
            background-color: #2d2d2d;
            color: #000000;
            transition: 1s ease;
        }

        .chat-card {
            height: 100%;
        }

        .chat-card .card-header {
            background-color: #000000;
            color: #fff;
            font-weight: bold;
        }

        .chat-body {
            height: calc(100% - 50px);
            overflow-y: scroll;
            border: 1px solid white;
            border-radius: 10px;

        }

        .chat-message {
            margin-bottom: 15px;
        }

        .chat-message-meta {
            margin-bottom: 5px;
            font-size: 0.8rem;
            color: #6c757d;
        }

        .chat-message-content {
            padding: 5px;
            border-radius: 10px;
            background-color: #f8f9fa;
            font-size: 0.9rem;
        }
    </style>

