<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['category', 'author'])->published();

        if ($request->filled('kategori')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->kategori));
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(fn($x) => $x->where('title', 'like', "%{$q}%")->orWhere('excerpt', 'like', "%{$q}%"));
        }

        $articles = $query->orderByDesc('published_at')->paginate(12);
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $featured = Article::published()->featured()->orderByDesc('published_at')->limit(3)->get();

        return view('articles.index', compact('articles', 'categories', 'featured'));
    }

    public function kategori(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $articles = Article::with(['category', 'author'])
            ->published()
            ->where('category_id', $category->id)
            ->orderByDesc('published_at')
            ->paginate(12);

        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('articles.index', compact('articles', 'categories', 'category'));
    }

    public function show(string $slug)
    {
        $article = Article::with(['category', 'author'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $article->incrementViewCount();

        $related = Article::with('category')
            ->published()
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('articles.show', compact('article', 'related'));
    }
}
