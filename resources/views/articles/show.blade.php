@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->excerpt ?? Str::limit(strip_tags($article->content), 150))
@section('og_title', $article->title)
@section('og_description', $article->excerpt)
@section('og_image', $article->featured_image ? Storage::url($article->featured_image) : asset('images/og-default.jpg'))

@section('content')

{{-- Header --}}
<div class="breadcrumb-section">
    <div class="container-sid">
        <div class="max-w-4xl mx-auto">
            @if($article->category)
            <a href="{{ route('berita.kategori', $article->category->slug) }}" class="badge badge-primary mb-3">
                {{ $article->category->name }}
            </a>
            @endif
            <h1 class="text-3xl md:text-5xl font-extrabold text-white leading-tight mb-4">
                {{ $article->title }}
            </h1>
            <div class="flex flex-wrap items-center gap-4 text-white/80 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center font-bold text-white text-xs">
                        {{ strtoupper(substr($article->author?->name ?? 'Admin', 0, 2)) }}
                    </div>
                    <span>{{ $article->author?->name ?? 'Redaksi Condongcatur' }}</span>
                </div>
                <span>•</span>
                <span>{{ $article->published_at?->translatedFormat('d F Y') }}</span>
                <span>•</span>
                <span>{{ $article->reading_time }} mnt baca</span>
                <span>•</span>
                <span>{{ number_format($article->view_count) }} kali dibaca</span>
            </div>
        </div>
    </div>
</div>

<div class="section-py">
    <div class="container-sid">
        <div class="max-w-4xl mx-auto">

            {{-- Featured Image --}}
            @if($article->featured_image)
            <div class="rounded-2xl overflow-hidden shadow-lg mb-8 aspect-video">
                <img
                    src="{{ Storage::url($article->featured_image) }}"
                    alt="{{ $article->title }}"
                    class="w-full h-full object-cover"
                >
            </div>
            @endif

            {{-- Excerpt Callout --}}
            @if($article->excerpt)
            <div class="p-6 bg-blue-50 border-l-4 border-blue-600 rounded-r-2xl mb-8 text-blue-900 font-medium leading-relaxed italic">
                "{{ $article->excerpt }}"
            </div>
            @endif

            {{-- Article Content Body --}}
            <div class="bg-white rounded-2xl p-6 md:p-10 shadow-sm border border-gray-100 prose prose-lg max-w-none prose-blue">
                {!! $article->content !!}
            </div>

            {{-- Share & Tags --}}
            <div class="flex flex-wrap items-center justify-between gap-4 mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-sm text-gray-700">Bagikan:</span>
                    <a href="https://facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center hover:opacity-90 transition-opacity">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-green-600 text-white flex items-center justify-center hover:opacity-90 transition-opacity">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                </div>
                <a href="{{ route('berita.index') }}" class="btn btn-outline text-sm">
                    ← Kembali ke Berita
                </a>
            </div>

            {{-- Related Articles --}}
            @if(isset($related) && $related->isNotEmpty())
            <div class="mt-16">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Berita Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($related as $rel)
                    <a href="{{ route('berita.show', $rel->slug) }}" class="news-card group">
                        <div class="news-card-img-wrap">
                            <img
                                src="{{ $rel->featured_image ? Storage::url($rel->featured_image) : placeholder_image(400, 250, $rel->title) }}"
                                alt="{{ $rel->title }}"
                                class="news-card-img"
                                loading="lazy"
                            >
                        </div>
                        <div class="news-card-body">
                            <h4 class="font-bold text-sm text-gray-900 line-clamp-2 mb-2 group-hover:text-blue-600 transition-colors">
                                {{ $rel->title }}
                            </h4>
                            <span class="text-xs text-gray-400 mt-auto">{{ $rel->published_at?->format('d M Y') }}</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

@endsection
