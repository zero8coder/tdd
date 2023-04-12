@foreach($threads as $thread)
    <div class="space-y-4 p-2">
        <div class="space-y-4 max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-8">
            <article>
                <div class="mt-1 block relative">
                    <span class="left-0">
                        <a class="text-lg leading-tight font-medium
                            @if(auth()->check() && $thread->hasUpdatesFor(auth()->user())) text-black  @else text-gray-500  @endif
                            hover:underline"
                           href="{{ $thread->path() }}"
                        >{{ $thread->title }}</a>
                    </span>
                    @if($thread->replies_count > 0)
                        <span class="absolute right-0 text-gray-500">
                                    {{ $thread->replies_count }}
                                </span>
                    @endif
                    <div class="block">
                        <h5><a href="{{ route('profile',$thread->creator) }}">{{ $thread->creator->name }}</a> 发布</h5>
                    </div>
                </div>
                <hr>
                <p class="mt-2 text-gray-500">       {{ $thread->body }}</p>
                <p class="mt-2 text-gray-500">浏览{{ $thread->visits }}</p>

            </article>
        </div>
    </div>
@endforeach