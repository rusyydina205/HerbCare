<x-app-layout>
    <div class="py-10 bg-[#f7f8f5] min-h-screen">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-10">
            <div class="mb-6 flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center p-4 bg-[#064e3b] border border-[#064e3b] text-white hover:bg-[#053d30] rounded-2xl hover:shadow-md transition-all shadow-sm" title="Back to Dashboard">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <a href="{{ route('dashboard') }}" class="text-xs sm:text-sm font-bold uppercase tracking-wider text-gray-400 hover:text-gray-600 transition-colors">Back to Dashboard</a>
            </div>
            <div class="grid gap-8 lg:grid-cols-[1.45fr_1fr] items-center rounded-[2rem] bg-white p-8 shadow-sm border border-gray-200">
                <div class="space-y-6">
                    <div class="inline-flex items-center rounded-full bg-[#eaf4e8] px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-[#0f2818]">Herb Library</div>
                    <div>
                        <h1 class="text-4xl sm:text-5xl font-serif font-bold text-[#0f2818] leading-tight">Explore and learn about herbs and their benefits.</h1>
                        <p class="mt-4 max-w-2xl text-base text-gray-600 leading-relaxed">Search all herbs, filter by health category, and discover rich botanical details in one clean library.</p>
                    </div>
                    <form method="GET" action="{{ route('herb.library') }}" class="grid gap-4 sm:grid-cols-[1.8fr_auto] lg:grid-cols-[2fr_auto] items-end">
                        <label class="relative block w-full">
                            <span class="sr-only">Search herbs</span>
                            <span class="absolute inset-y-0 left-5 flex items-center text-green-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"></path></svg>
                            </span>
                            <input
                                type="search"
                                name="search"
                                value="{{ $search ?? '' }}"
                                placeholder="Search all herbs..."
                                class="w-full rounded-[1.75rem] border border-[#064e3b] bg-[#f1f7f0] py-4 pl-14 pr-5 text-sm text-[#0f2818] shadow-sm focus:border-[#064e3b] focus:outline-none focus:ring-2 focus:ring-[#064e3b]/25"
                            />
                        </label>
                        <button type="submit" class="rounded-[1.75rem] bg-[#064e3b] px-7 py-4 text-sm font-semibold text-white transition hover:bg-[#053d30]">Search</button>
                    </form>
                    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                        <label class="block">
                            <span class="sr-only">Filter by category</span>
                            <select name="category" onchange="this.form.submit()" class="w-full rounded-[1.75rem] border border-gray-200 bg-white py-4 px-5 text-sm text-gray-700 shadow-sm focus:border-[#0f2818] focus:outline-none focus:ring-2 focus:ring-[#0f2818]/15">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->categoryId }}" @selected((string)($selectedCategory ?? '') === (string)$category->categoryId)>{{ $category->categoryName }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block">
                            <span class="sr-only">Sort herbs</span>
                            <select name="sort" class="w-full rounded-[1.75rem] border border-gray-200 bg-white py-4 px-5 text-sm text-gray-700 shadow-sm focus:border-[#0f2818] focus:outline-none focus:ring-2 focus:ring-[#0f2818]/15">
                                <option value="alphabetical" @selected(($sort ?? 'alphabetical') === 'alphabetical')>A - Z</option>
                                <option value="az" @selected(($sort ?? '') === 'az')>A - Z</option>
                                <option value="za" @selected(($sort ?? '') === 'za')>Z - A</option>
                            </select>
                        </label>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('herb.library') }}" class="inline-flex items-center justify-center rounded-[1.75rem] border border-gray-200 bg-white px-5 py-4 text-sm font-semibold text-gray-700 transition hover:border-[#0f2818] hover:text-[#0f2818]">Clear</a>
                            <span class="text-sm font-semibold text-gray-500">{{ $herbs->count() }} herbs found</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-[2rem] bg-[#064e3b] p-8 shadow-sm border border-[#0f2818]">
                    <div class="flex h-full flex-col justify-between rounded-[1.75rem] bg-[#0f291a]/95 p-6 shadow-inner">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-green-100/80">Herb Library</p>
                            <h2 class="mt-4 text-3xl font-semibold text-white">A darker browsing experience</h2>
                            <p class="mt-3 text-sm text-green-100 leading-relaxed">No featured herb image — just the cards and search tools you need to explore the library.</p>
                        </div>
                        <div class="mt-6 inline-flex items-center gap-3 rounded-full bg-green-800 px-4 py-3 text-xs font-semibold uppercase tracking-[0.25em] text-white">
                            <span class="inline-block h-2 w-2 rounded-full bg-white"></span>
                            Browse herbs freely
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex flex-col gap-3 overflow-x-auto pb-1">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('herb.library') }}" class="inline-flex items-center rounded-full border px-4 py-2 text-sm font-semibold transition-all {{ empty($selectedCategory) ? 'bg-[#0f2818] text-white border-transparent' : 'bg-white text-gray-700 border-gray-200 hover:border-[#0f2818] hover:text-[#0f2818]' }}">All</a>
                    @foreach($categories as $category)
                        <a href="{{ route('herb.library', array_merge(request()->except('page'), ['category' => $category->categoryId])) }}" class="inline-flex items-center rounded-full border px-4 py-2 text-sm font-semibold transition-all {{ isset($selectedCategory) && (string)$selectedCategory === (string)$category->categoryId ? 'bg-[#0f2818] text-white border-transparent' : 'bg-white text-gray-700 border-gray-200 hover:border-[#0f2818] hover:text-[#0f2818]' }}">{{ $category->categoryName }}</a>
                    @endforeach
                </div>
            </div>

            <div class="mt-8 grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($herbs as $herb)
                    <article onclick="window.location='{{ route('herb.show', $herb->herbId) }}'" class="group relative flex flex-col h-full overflow-hidden rounded-[1.75rem] border border-gray-200 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-2xl hover:border-[#064e3b] cursor-pointer">
                        <div class="h-52 shrink-0 overflow-hidden bg-slate-100">
                            <img src="{{ asset($herb->image) }}" alt="{{ $herb->herbName }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                                <span class="inline-flex items-center rounded-full bg-[#eff6ee] px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.24em] text-[#064e3b]">{{ $herb->category->categoryName ?? 'General' }}</span>
                                <span class="text-[11px] font-semibold text-gray-400">{{ \Illuminate\Support\Str::limit($herb->scientificName, 24) }}</span>
                            </div>
                            <h2 class="text-xl font-semibold text-[#0f2818] mb-2">{{ $herb->herbName }}</h2>
                            <p class="text-sm leading-relaxed text-gray-600 mb-6 flex-grow">{{ \Illuminate\Support\Str::limit($herb->benefits ?: 'A natural remedy with traditional benefits for wellbeing.', 110) }}</p>
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <span class="flex w-full items-center justify-center gap-2 rounded-full bg-[#064e3b] px-5 py-2.5 text-sm font-semibold text-white transition-all duration-300 group-hover:bg-[#053d30] group-hover:shadow-md group-hover:gap-3">
                                    View Details
                                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="sm:col-span-2 xl:col-span-3 rounded-[2rem] border border-dashed border-gray-300 bg-white p-12 text-center text-gray-500 shadow-sm">
                        <p class="text-lg font-semibold">No herbs match your search.</p>
                        <p class="mt-3 text-sm leading-relaxed">Try another keyword or reset the category filter to see all herbs.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
