
<x-layout>
    <x-slot:title>
        Posts Feed
    </x-slot:title>
    
    <div class="max-w-2xl mx-auto mt-6 space-y-8">
        
        <!-- Post Form -->
        <div class="card bg-base-100 shadow-md rounded-2xl p-6">
            <x-postForm />
        </div>
    
        <!-- Posts Feed -->
        <div>
            <h1 class="text-2xl text-center  font-bold mb-4 ">Latest Posts</h1>
    
            <div class="space-y-4">
                @forelse ($posts as $post)
                    <x-postComponent :post="$post" />
                @empty
                    <div class="hero py-12">
                        <div class="hero-content text-center">
                            <div>
                                <svg class="mx-auto h-12 w-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <p class="mt-4 text-base-content/60">No posts yet. Be the first!</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
</x-layout>