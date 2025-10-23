<x-layout>
    <x-slot:title>
        Edit Post
    </x-slot:title>

    <!-- Centered Wrapper -->
    <div class="max-w-3xl mx-auto mt-8 space-y-8 px-4">
        <form action="{{ route('post.update', $post->id) }}"
              method="POST" 
              enctype="multipart/form-data" 
              class="edit-post-form">
            @csrf
            @method('PUT')

            <h2 class="text-2xl font-semibold text-center mb-6 text-primary">Edit Your Post</h2>

            <!-- Content Field -->
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea name="content" id="content" rows="5" placeholder="What's on your mind?">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Media Section -->
            <div class="form-group">
                <label for="media_url">Upload Image/Video:</label>

                @if($post->media_url)
                    <div class="current-media">
                        <p class="text-gray-500 text-sm mb-2">Current media:</p>
                        <img src="{{ Storage::url($post->media_url) }}" 
                             alt="Post media"
                             class="current-image">
                    </div>
                @endif

                <input type="file" name="media" id="media_url" accept="image/*,video/*">
                @error('media')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="form-submit">
                <button type="submit">Update Post</button>
            </div>
        </form>
    </div>

    <style>
        :root {
            --accent-color: #6AA84F;
            --accent-hover: #558d3f;
        }

        .edit-post-form {
            width: 500px;
            max-width: 90%;
            background: #ffffff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333333;
        }

        .form-group textarea {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            resize: vertical;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group textarea:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px rgba(106,168,79,0.2);
            outline: none;
        }

        .form-group input[type="file"] {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group input[type="file"]:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px rgba(106,168,79,0.2);
            outline: none;
        }

        .current-media {
            margin-bottom: 10px;
        }

        .current-image {
            width: 100%;
            max-width: 500px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .error {
            color: #ff4d4f;
            font-size: 12px;
            margin-top: 4px;
        }

        .form-submit {
            display: flex;
            justify-content: flex-end;
        }

        .form-submit button {
            background-color: var(--accent-color);
            color: white;
            font-weight: 600;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
        }

        .form-submit button:hover {
            background-color: var(--accent-hover);
            transform: translateY(-1px);
        }
    </style>
</x-layout>
