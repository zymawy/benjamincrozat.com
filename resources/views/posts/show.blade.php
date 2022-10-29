<x-app
    :title="$post->title"
    :description="$post->description"
    :image="$post->image"
>
    <div class="container sm:flex sm:items-center sm:justify-between py-8 text-center sm:text-left">
        <a href="{{ route('home') }}">
            <span class="font-extrabold translate-y-px text-sm sm:text-base tracking-widest uppercase">
                Benjamin Crozat
            </span>

            <span class="block opacity-75 text-xs tracking-widest uppercase">
                The web developer life
            </span>
        </a>

        <nav class="flex items-center justify-center sm:justify-start gap-8 mt-8 sm:mt-0">
            <a href="{{ route('posts.index') }}" class="hover:opacity-50 text-xs tracking-widest transition-opacity uppercase">
                Blog
            </a>

            <a href="{{ route('home') }}" class="bg-indigo-400 hover:opacity-50 px-3 py-2 rounded text-white tracking-widest text-xs transition-opacity uppercase">
                Hire me!
            </a>
        </nav>
    </div>

    <x-breadcrumb class="mt-16">
        <x-breadcrumb-item>
            {{ $post->title }}
        </x-breadcrumb-item>
    </x-breadcrumb>

    <article class="mt-8">
        {{-- Post --}}
        <div class="container">
            {{-- Title --}}
            <h1 class="font-thin text-3xl md:text-5xl">
                {{ $post->title }}
            </h1>

            {{-- Metadata --}}
            <div class="flex items-center gap-2 mt-4 text-sm">
                <img src="https://www.gravatar.com/avatar/{{ md5('benjamincrozat@me.com') }}" width="18" height="18" alt="Benjamin Crozat's avatar." class="-translate-y-[.5px] rounded-full" />

                <p>
                    <a href="https://twitter.com/benjamincrozat" target="_blank" rel="noopener noreferrer" class="font-normal" @click="window.fathom?.trackGoal('LNRXVF3B', 0)">Benjamin Crozat</a>

                    <span class="mx-1">—</span>

                    @choice(':count minute|:count minutes', $post->getReadTime()) read
                </p>
            </div>

            <x-table-of-contents :post="$post" />

            {{-- Content --}}
            <div class="max-w-full mt-8 prose prose-a:border-b prose-a:border-indigo-200 prose-a:text-indigo-400 prose-a:no-underline">
                {!! Illuminate\Support\Str::marxdown($post->content) !!}
            </div>
        </div>

        {{-- Newsletter --}}
        <div class="bg-gray-100 mt-16">
            <aside class="container py-16">
                <x-newsletter class="scroll-mt-8 sm:scroll-mt-16" />
            </aside>
        </div>

        {{-- Other posts to read --}}
        @if ($others->isNotEmpty())
            <div class="container max-w-[1024px] py-16">
                <h4 class="font-bold text-center text-xl">Other posts to read</h4>

                <ul class="grid sm:grid-cols-2 gap-12 sm:gap-8 mt-8">
                    @foreach ($others as $post)
                        <li><x-post :post="$post" /></li>
                    @endforeach
                </ul>
            </div>
        @endif
    </article>

    <div class="bg-gray-900 flex-grow">
        <x-footer class="text-gray-400" links-color="text-gray-300" />
    </div>

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [{
                "@type": "ListItem",
                "position": 1,
                "name": "{{ $post->title }}"
            }]
        }
    </script>

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "headline": "{{ $post->title }}",
            "datePublished": "{{ $post->getPublishedAtDate()?->toIso8601String() }}",

            @if ($post->getModifiedAtDate())
                "dateModified": "{{ $post->getModifiedAtDate()?->toIso8601String() }}",
            @endif

            "author": [
                {
                    "@type": "Person",
                    "name": "Benjamin Crozat",
                    "url": "{{ route('home') }}"
                }
            ]
        }
    </script>
</x-app>
