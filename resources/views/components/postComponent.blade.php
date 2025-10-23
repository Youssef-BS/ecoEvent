@props(['post'])

<div class="card bg-base-100 shadow-md rounded-2xl p-6 mb-6">
    <div class="flex items-start space-x-4">
        <!-- User Avatar -->
        <div class="avatar w-12 h-12 rounded-full bg-gray-200 flex-shrink-0"></div>

        <!-- Post Content -->
        <div class="flex-1 min-w-0">
            <!-- User + Time -->
            <div class="flex items-center space-x-2 mb-2">
                <span class="font-semibold text-base">{{ $post->user->first_name }}</span>
                <span class="text-gray-400">·</span>
                <span class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</span>

                @if($post->user->id == auth()->id())
                <div class="flex gap-2">
                    <a href="{{ route('post.edit', $post) }}" 
                    class="inline text-blue-500 text-xs hover:text-blue-700">
                        ✏️
                    </a>

                    <!-- Delete Form -->
                    <form method="POST" action="{{ route('post.delete', $post->id) }}" class="inline-btn">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this comment?')"
                                class=" inline-btn text-red-500 text-xs hover:text-red-700">
                                <span class="glyphicon">&#9003;</span>
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <!-- Post Text -->
            <p class="mt-1 text-gray-700">{{ $post->content }}</p>

            <!-- Post Media (Image/Video) -->
            @if($post->media_url)
                @php $ext = strtolower(pathinfo($post->media_url, PATHINFO_EXTENSION)) @endphp
                @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                    <img src="{{ Storage::url($post->media_url) }}" 
                         class="rounded-lg shadow-md mt-3"
                         style="width: 500px; max-width: 100%; height: auto; object-fit: cover;">
                @elseif(in_array($ext, ['mp4','webm','ogg']))
                    <video controls class="rounded-lg shadow-md mt-3 w-full max-h-80">
                        <source src="{{ Storage::url($post->media_url) }}" type="video/{{ $ext }}">
                    </video>
                @endif
            @endif

            <!-- Like & Comment Buttons -->
            <div class="flex items-center gap-4 mt-4">
                <form method="POST" action="{{ route('likes.toggle', $post->id) }}">
                    @csrf
                    <button type="submit" 
                        class="btn btn-sm {{ $post->likes()->where('user_id', Auth::id())->exists() ? 'bg-gray-100 border-gray-300 text-gray-800' : 'bg-white border-gray-300 text-gray-800' }}">
                        {{ $post->likes()->where('user_id', Auth::id())->exists() ? 'Liked ❤️' : 'Like' }} ({{ $post->likes->count() }})
                    </button>
                </form>
                <span class="text-gray-500">{{ $post->comments->count() }} Comments</span>
            </div>

            <!-- Comments Section -->
            <div class="mt-4 space-y-2" id="comments-container-{{ $post->id }}">
                <!-- Initial 2 comments -->
                @foreach($post->comments()->latest()->take(2)->get() as $comment)
                    <div class="comment comment-{{ $post->id }} initial-comment" id="comment-{{ $comment->id }}">
                        <div class="flex items-start gap-2 bg-base-200 rounded-lg p-2">
                            <div class="avatar"></div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="font-semibold">{{ $comment->user->first_name }}</span>
                                        <span class="text-gray-500 text-xs">· {{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if($comment->user->id == auth()->id())
                                        <div class="flex gap-2">
                                            <!-- Edit Button -->
                                            <button
                                                    onclick="enableEditComment({{ $comment->id }})"
                                                    class="inline-btn text-blue-500 text-xs hover:text-blue-700">
                                                    <span class="glyphicon">&#9998;</span>
                                            </button>
                                        
                                            <!-- Delete Form -->
                                            <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" class="inline-btn">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to delete this comment?')"
                                                        class="inline-btn text-red-500 text-xs hover:text-red-700">
                                                        <span class="glyphicon">&#9003;</span>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Comment Content Display -->
                                <div id="comment-content-{{ $comment->id }}">
                                    <span class="text-sm mt-1">{{ $comment->content }}</span>
                                </div>
                                
                                <!-- Edit Form (Hidden Initially) -->
                                @if($comment->user->id == auth()->id())
                                    <form method="POST" 
                                          action="{{ route('comments.update', $comment) }}"
                                          id="edit-form-{{ $comment->id }}"
                                          class="hidden mt-2">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex gap-2">
                                            <input type="text" 
                                                   name="content" 
                                                   value="{{ $comment->content }}"
                                                   class="input input-bordered input-sm flex-1"
                                                   required>
                                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                                            <button type="button" 
                                                    onclick="cancelEditComment({{ $comment->id }})"
                                                    class="btn btn-sm btn-ghost">Cancel</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Show More/Less Buttons -->
            @if($post->comments->count() > 2)
                <div class="mt-3 flex gap-2" id="comment-buttons-{{ $post->id }}">
                    <button type="button" 
                            onclick="loadMoreComments({{ $post->id }})" 
                            class="btn btn-sm btn-ghost text-primary show-more-btn"
                            data-offset="2"
                            data-total="{{ $post->comments->count() }}">
                        Show More ({{ $post->comments->count() - 2 }} more)
                    </button>
                    <button type="button" 
                            onclick="collapseComments({{ $post->id }})" 
                            class="btn btn-sm btn-ghost text-primary collapse-btn hidden">
                        Show Less
                    </button>
                </div>
            @endif

            <!-- Add Comment Form -->
            <form method="POST" action="{{ route('comments.store', $post->id) }}" class="mt-3 flex gap-2">
                @csrf
                <input name="content" type="text" placeholder="Write a comment..." 
                       class="input input-bordered input-sm w-full" required>
                <button type="submit" class="btn btn-sm btn-primary">Comment</button>
            </form>
        </div>
    </div>
</div>

<script>
async function loadMoreComments(postId) {
    const button = document.querySelector(`#comment-buttons-${postId} .show-more-btn`);
    const offset = parseInt(button.dataset.offset);
    const totalComments = parseInt(button.dataset.total);
    
    try {
        const response = await fetch(`/posts/${postId}/comments?offset=${offset}&limit=2`);
        const comments = await response.json();
        
        const container = document.getElementById(`comments-container-${postId}`);
        
        // Add new comments
        if (comments && comments.length > 0) {
            comments.forEach(comment => {
                const commentHtml = `
<div class="comment comment-${postId} loaded-comment" id="comment-${comment.id}">
    <div class="flex items-start gap-2 bg-base-200 rounded-lg p-2">
        <div class="avatar"></div>
        <div class="flex-1">
            <div class="flex justify-between items-start">
                <div>
                    <span class="font-semibold">${comment.user.first_name}</span>
                    <span class="text-gray-500 text-xs">· ${comment.time_ago}</span>
                </div>
                ${comment.can_edit ? `
                <div class="flex gap-2">
                    <!-- Edit Button -->
                    <button onclick="enableEditComment(${comment.id})"
                            class="inline-btn text-blue-500 text-xs hover:text-blue-700">
                        <span class="glyphicon">&#9998;</span>
                    </button>

                    <!-- Delete Form -->
                    <form method="POST" action="/comments/${comment.id}" class="inline-btn">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this comment?')"
                                class="inline-btn text-red-500 text-xs hover:text-red-700">
                            <span class="glyphicon">&#9003;</span>
                        </button>
                    </form>
                </div>
                ` : ''}
            </div>
            
            <!-- Comment Content Display -->
            <div id="comment-content-${comment.id}">
                <span class="text-sm mt-1">${comment.content}</span>
            </div>
            
            ${comment.can_edit ? `
            <!-- Edit Form (Hidden Initially) -->
            <form method="POST" 
                  action="/comments/${comment.id}"
                  id="edit-form-${comment.id}"
                  class="hidden mt-2">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="PUT">
                <div class="flex gap-2">
                    <input type="text" 
                           name="content" 
                           value="${comment.content}"
                           class="input input-bordered input-sm flex-1"
                           required>
                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                    <button type="button" 
                            onclick="cancelEditComment(${comment.id})"
                            class="btn btn-sm btn-ghost">Cancel</button>
                </div>
            </form>
            ` : ''}
        </div>
    </div>
</div>`;
                container.insertAdjacentHTML('beforeend', commentHtml);
            });
            
            // Update offset
            const newOffset = offset + comments.length;
            button.dataset.offset = newOffset;
            
            // Calculate remaining comments
            const remainingComments = totalComments - newOffset;
            
            // Update button text or hide if no more comments
            if (remainingComments > 0) {
                button.textContent = `Show More (${remainingComments} more)`;
            } else {
                button.classList.add('hidden');
            }
            
            // Show collapse button if it's not already visible
            document.querySelector(`#comment-buttons-${postId} .collapse-btn`).classList.remove('hidden');
        }
        
    } catch (error) {
        console.error('Error loading comments:', error);
    }
}

function collapseComments(postId) {
    const container = document.getElementById(`comments-container-${postId}`);
    const buttonsContainer = document.getElementById(`comment-buttons-${postId}`);
    
    // Remove all loaded comments (keep only initial 2)
    const loadedComments = container.querySelectorAll('.loaded-comment');
    loadedComments.forEach(comment => {
        comment.remove();
    });
    
    // Reset show more button
    const showMoreBtn = buttonsContainer.querySelector('.show-more-btn');
    showMoreBtn.dataset.offset = '2';
    showMoreBtn.classList.remove('hidden');
    
    const totalComments = parseInt(showMoreBtn.dataset.total);
    const remainingComments = totalComments - 2;
    showMoreBtn.textContent = `Show More (${remainingComments} more)`;
    
    // Hide collapse button
    buttonsContainer.querySelector('.collapse-btn').classList.add('hidden');
}

// Edit Comment Functions
function enableEditComment(commentId) {
    // Hide the comment content
    const contentDiv = document.getElementById(`comment-content-${commentId}`);
    if (contentDiv) {
        contentDiv.classList.add('hidden');
    }
    
    // Show the edit form
    const editForm = document.getElementById(`edit-form-${commentId}`);
    if (editForm) {
        editForm.classList.remove('hidden');
    }
}

function cancelEditComment(commentId) {
    // Show the comment content
    const contentDiv = document.getElementById(`comment-content-${commentId}`);
    if (contentDiv) {
        contentDiv.classList.remove('hidden');
    }
    
    // Hide the edit form
    const editForm = document.getElementById(`edit-form-${commentId}`);
    if (editForm) {
        editForm.classList.add('hidden');
    }
}
</script>

<style>
.hidden {
    display: none;
}

.inline-btn {
  display: inline;
  background: transparent;
  border: none;
  padding: 0;
  margin: 0;
  color: #2563eb; /* blue-600 */
  cursor: pointer;
}

button.inline-btn:hover {
  color: #1d4ed8; /* darker blue */
}
</style>