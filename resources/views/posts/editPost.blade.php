
<x-layout>
    <x-slot:title>
        Edit Post
    </x-slot:title>
    
    <div class="max-w-2xl mx-auto mt-6 space-y-8">
        <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium mb-1">Content</label>
                <textarea name="content" id="content" rows="4"
                          class="textarea textarea-bordered w-full"
                          placeholder="What's on your mind?">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        
            
            <!-- Media (Image or Video) -->
            <div>
                <label for="media_url" class="block text-sm font-medium mb-1">Upload Media</label>
                @if($post->media_url)
                    <p>Current media:</p>
                        <img src="{{ Storage::url($post->media_url) }}"
                        alt="Post"
                        class="rounded-lg shadow max-h-96 object-cover w-full"
                        width="500">
                    
                @endif

                <input type="file" name="media" id="media_url"
                       accept="image/*,video/*"
                       class="file-input file-input-bordered w-full" />
                @error('media')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        
            <!-- Submit Button -->
            <div class="w-full flex justify-end">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            
        </form>
      
    </div>
    
</x-layout>