<div x-data="{ open: false }">
    <a @click="open = !open" style="cursor: pointer;" class="userhover" wire:click="markAllNotificationsAsRead">
        <div class="hover">
            <svg aria-label="Notifications" class="_ab6-" color="rgb(245, 245, 245)" fill="rgb(245, 245, 245)" height="24" role="img" viewBox="0 0 24 24" width="24"><path d="M16.792 3.904A4.989 4.989 0 0 1 21.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 2.5 9.122a4.989 4.989 0 0 1 4.708-5.218 4.21 4.21 0 0 1 3.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 0 1 3.679-1.938m0-2a6.04 6.04 0 0 0-4.797 2.127 6.052 6.052 0 0 0-4.787-2.127A6.985 6.985 0 0 0 .5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 0 0 3.518 3.018 2 2 0 0 0 2.174 0 45.263 45.263 0 0 0 3.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 0 0-6.708-7.218Z"></path></svg>
            @if($this->unreadCount > 0)
                <span class="badge" id="unread-notifications-count">{{ $this->unreadCount }}</span>
            @endif
        </div>
        <span style="font-size: 20px;">Notifications</span>
    </a>
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90" class="fixed top-0 right-0 w-1/2 bg-black h-full overflow-y-auto">
        <div class="col-md">
                @foreach($this->notifications as $notification)
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
        </div>
    </div>
</div>
