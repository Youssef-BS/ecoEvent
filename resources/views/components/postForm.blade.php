<form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data"
      class="post-form">
    @csrf

    <!-- Content Field -->
    <div class="form-group">
        <label for="content">Content:</label>
        <textarea name="content" id="content" rows="5" placeholder="What's on your mind?">{{ old('content') }}</textarea>
        @error('content')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <!-- Media Upload Field -->
    <div class="form-group">
        <label for="media_url">Upload Image/Video:</label>
        <input type="file" name="media" id="media_url" accept="image/*,video/*">
        @error('media')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit Button -->
    <div class="form-submit">
        <button type="submit">Post</button>
    </div>
</form>

<style>
/* Center the form and set width */
.post-form {
    width: 500px;           /* fixed width */
    max-width: 90%;         /* responsive on small screens */
    margin: 40px auto;      /* center horizontally */
    background: #ffffff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    font-family: 'Inter', sans-serif;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

/* Form groups (label + input) */
.form-group {
    display: flex;
    flex-direction: column;
}

/* Labels */
.form-group label {
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 14px;
    color: #333333;
}

/* Textarea */
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
    border-color: #6AA84F;
    box-shadow: 0 0 0 2px rgba(106,168,79,0.2);
    outline: none;
}

/* File input */
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
    border-color: #6AA84F;
    box-shadow: 0 0 0 2px rgba(106,168,79,0.2);
    outline: none;
}

/* Error messages */
.error {
    color: #ff4d4f;
    font-size: 12px;
    margin-top: 4px;
}

/* Submit button container */
.form-submit {
    display: flex;
    justify-content: flex-end;
}

/* Submit button */
.form-submit button {
    background-color: #6AA84F;
    color: white;
    font-weight: 600;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.2s, transform 0.1s;
}

.form-submit button:hover {
    background-color: #558d3f;
    transform: translateY(-1px);
}

.form-submit button:active {
    transform: translateY(0);
}
</style>
