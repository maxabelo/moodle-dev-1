<div>
    {{-- forelse : loop only if there are many items, otherwise print @empty block --}}
    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <div class="">
                    {{-- <a href="{{ route('posts.show', ['user'=>$user, 'post'=>$post]) }}"> --}}
                    <a href="{{ route('posts.show', [$post->user, $post]) }}">
                        <img src="{{ asset('uploads') . '/' . $post->image }}" alt="Post image | {{ $post->title }}">
                    </a>
                </div>
            @endforeach
        </div>
        <div class="my-10">
            {{-- laravel ya mete la logica de la paginacion | defaul pagining with tailwindcss styles --}}
            {{ $posts->links() }}
        </div>
    @else
        <p class="">You must follow someone to see their posts</p>
    @endif
</div>
