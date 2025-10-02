@props(['post'])

<div class="card bg-base-100 shadow-md rounded-2xl p-4 mb-4">
    <div class="flex items-start space-x-3">
        <!-- User Avatar -->
        <div class="avatar">
            <!-- Avatar content here -->
        </div>

        <!-- Post Content -->
        <div class="flex-1 min-w-0">
            <!-- User + Time -->
            <div class="flex items-center space-x-2">
                <span class="font-semibold text-base">{{ $post->user->first_name }}</span>
                <span class="text-gray-400">·</span>
                <span class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
            </div>

            <!-- Post Text -->
            <p class="mt-2 text-base-content/80">
                {{ $post->content }}
            </p>

            @if ($post->user_id == Auth::id())
                <div class="flex gap-1">
                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-ghost btn-xs">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('post.delete', $post->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Are you sure you want to delete this post?')"
                            class="btn btn-ghost btn-xs text-error">
                            Delete
                        </button>
                    </form>
                    
                </div>
            @endif

            <!-- Post Media (Image/Video) -->
            @if($post->media_url)
            <div class="mt-3">
                @php
                    $extension = strtolower(pathinfo($post->media_url, PATHINFO_EXTENSION));
                @endphp

                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                    <img src="{{ Storage::url($post->media_url) }}" 
                         alt="Post" 
                         class="rounded-lg shadow max-h-96 object-cover w-full"
                         width="500">
                @elseif(in_array($extension, ['mp4', 'webm', 'ogg']))
                    <video controls class="rounded-lg shadow max-h-96 w-full">
                        <source src="{{ Storage::url($post->media_url) }}" type="video/{{ $extension }}">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>