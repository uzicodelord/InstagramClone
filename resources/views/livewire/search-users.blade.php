<div>
    <input class="form-control comment" type="text" wire:model="searchTerm" placeholder="Search users...">
    @if($searchTerm != "")
        @if(count($users) > 0)
            @foreach($users as $user)
                <hr>
                <a href="{{ route('profiles.show', $user->name) }}" class="userhover">
                    <div class="profile-info-wrapper d-flex align-items-center justify-content-start">
                        <div class="profile-picture-post-comment">
                            <img src="{{ asset(Storage::url($user->profile_picture)) }}" alt="{{ $user->name }}'s Profile Picture" class="rounded-circle">
                        </div>
                        <div class="profile-info">
                            <span class="profile-name">{{ $user->name }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            <div class="not-found">Not found</div>
        @endif
    @endif
</div>
