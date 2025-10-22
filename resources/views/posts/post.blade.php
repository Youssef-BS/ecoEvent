<x-layout>
    <x-slot:title>
        Posts Feed
    </x-slot:title>

    <div class="max-w-3xl mx-auto mt-8 space-y-8 px-4">

        <!-- Centered Post Form -->
        <div class="flex justify-center">
            <div class="bg-white shadow-lg rounded-2xl p-6 transition transform hover:-translate-y-1 hover:shadow-2xl w-full max-w-lg">
                <x-postForm />
            </div>
        </div>

        <!-- Posts Feed Header -->
        <div>
            <h1 class="text-3xl text-center font-extrabold text-primary mb-6">Latest Posts</h1>
        </div>

        <!-- Posts Feed -->
        <div class="space-y-6">
            @forelse ($posts as $post)
                <div class="bg-white rounded-2xl shadow-md p-5 hover:shadow-lg transition transform hover:-translate-y-1">
                    <x-postComponent :post="$post" />
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-16 bg-white rounded-2xl shadow-md">
                    <svg class="h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="mt-4 text-gray-400 text-lg text-center">No posts yet. Be the first to share your thoughts!</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>

<style>
    /* Custom colors to match Charitize theme */
    :root {
        --primary-color: #3A6351;
        --accent-color: #6AA84F;
        --bg-card: #ffffff;
    }
    .text-primary { color: var(--primary-color); }
    .bg-white { background-color: var(--bg-card); }

    /* Optional: add some spacing on small screens */
    @media (max-width: 640px) {
        .max-w-3xl {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
