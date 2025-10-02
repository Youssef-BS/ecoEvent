<form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <!-- Content -->
    <div>
        <label for="content" class="block text-sm font-medium mb-1">Content</label>
        <textarea name="content" id="content" rows="4"
                  class="textarea textarea-bordered w-full"
                  placeholder="What's on your mind?">{{ old('content') }}</textarea>
        @error('content')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Media (Image or Video) -->
    <div>
        <label for="media_url" class="block text-sm font-medium mb-1">Upload Media</label>
        <input type="file" name="media" id="media_url"
               accept="image/*,video/*"
               class="file-input file-input-bordered w-full" />
        @error('media')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit Button -->
    <div class="w-full flex justify-end">
        <button type="submit" class="btn btn-primary">Post</button>
    </div>
    
</form>
