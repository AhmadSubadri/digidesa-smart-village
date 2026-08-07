@extends('layouts.app')

@section('title', isset($category) ? 'Berita Kategori ' . $category->name : 'Berita & Artikel')
@section('description', 'Daftar berita, artikel, dan kabar terbaru seputar Kalurahan Condongcatur, Sleman.')

@section('content')

{{-- Breadcrumb Header --}}
<div class="breadcrumb-section">
    <div class="container-sid">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">
            {{ isset($category) ? 'Kategori: ' . $category->name : 'Berita & Artikel' }}
        </h1>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">/</span>
            <a href="{{ route('berita.index') }}">Berita</a>
            @if(isset($category))
                <span class="sep">/</span>
                <span class="current">{{ $category->name }}</span>
            @else
                <span class="sep">/</span>
                <span class="current">Semua</span>
            @endif
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            {{-- Main Content (Articles Grid) --}}
            <div class="lg:col-span-3">

                {{-- Filter & Search Bar --}}
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 mb-8">
                    <form action="{{ route('berita.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Cari berita atau artikel..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue-600 transition-colors"
                            >
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <button type="submit" class="btn btn-primary py-2.5 text-sm">
                            Cari
                        </button>
                    </form>

                    {{-- Category Pills --}}
                    <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('berita.index') }}"
                           class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all {{ !request('kategori') && !isset($category) ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            Semua
                        </a>
                        @foreach($categories as $cat)
                        <a href="{{ route('berita.kategori', $cat->slug) }}"
                           class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all {{ (isset($category) && $category->id === $cat->id) || request('kategori') === $cat->slug ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $cat->name }}
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Article List --}}
                @if($articles->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($articles as $article)
                    <a href="{{ route('berita.show', $article->slug) }}" class="news-card group">
                        <div class="news-card-img-wrap">
                            <img
                                src="{{ $article->featured_image ? Storage::url($article->featured_image) : 'https://picsum.photos/600/400?random=' . $article->id }}"
                                alt="{{ $article->title }}"
                                class="news-card-img"
                                loading="lazy"
                            >
                        </div>
                        <div class="news-card-body">
                            @if($article->category)
                            <span class="news-card-category" style="background-color: {{ $article->category->color ?? '#2563EB' }}20; color: {{ $article->category->color ?? '#2563EB' }}">
                                {{ $article->category->name }}
                            </span>
                            @endif
                            <h3 class="news-card-title">{{ $article->title }}</h3>
                            <p class="news-card-excerpt">{{ $article->excerpt }}</p>
                            <div class="news-card-meta">
                                <span>{{ $article->published_at?->format('d M Y') }}</span>
                                <span class="ml-auto">{{ $article->reading_time }} mnt baca</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-10">
                    {{ $articles->links() }}
                </div>
                @else
                <div class="bg-white rounded-2xl p-12 text-center border border-gray-100">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Berita</h3>
                    <p class="text-sm text-gray-500">Tidak ada berita yang cocok dengan kriteria pencarian Anda.</p>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">

                {{-- Categories Widget --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 text-base mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Kategori
                    </h3>
                    <div class="space-y-2">
                        @foreach($categories as $cat)
                        <a href="{{ route('berita.kategori', $cat->slug) }}" class="flex items-center justify-between py-2 px-3 rounded-xl hover:bg-blue-50 text-sm font-medium text-gray-700 transition-colors">
                            <span>{{ $cat->name }}</span>
                            <span class="badge badge-gray">{{ $cat->articles_count ?? $cat->articles()->published()->count() }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Popular / Featured Articles Widget --}}
                @if(isset($featured) && $featured->isNotEmpty())
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 text-base mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Berita Pilihan
                    </h3>
                    <div class="space-y-4">
                        @foreach($featured as $feat)
                        <a href="{{ route('berita.show', $feat->slug) }}" class="flex gap-3 group">
                            <img
                                src="{{ $feat->featured_image ? Storage::url($feat->featured_image) : 'https://picsum.photos/100/100?random=' . $feat->id }}"
                                alt="{{ $feat->title }}"
                                class="w-16 h-16 rounded-xl object-cover shrink-0"
                            >
                            <div>
                                <h4 class="text-xs font-bold text-gray-800 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                    {{ $feat->title }}
                                </h4>
                                <span class="text-xs text-gray-400 mt-1 block">{{ $feat->published_at?->format('d M Y') }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection
