<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\Banner;
use App\Models\QuickLink;
use App\Models\Album;
use App\Models\Official;
use App\Models\Padukuhan;
use App\Models\BudgetPeriod;
use App\Models\IdmScore;
use App\Models\Development;
use App\Models\Faq;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Hero Banners
        $banners = Banner::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Quick Links
        $quickLinks = QuickLink::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        // Featured & Latest Articles
        $featuredArticles = Article::with(['category', 'author'])
            ->published()
            ->featured()
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $latestArticles = Article::with(['category', 'author'])
            ->published()
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        // Upcoming Events
        $upcomingEvents = Event::where('is_published', true)
            ->where('status', 'upcoming')
            ->where('start_datetime', '>=', now())
            ->orderBy('start_datetime')
            ->limit(4)
            ->get();

        // Pinned Announcements
        $pinnedAnnouncements = Announcement::active()
            ->where('is_pinned', true)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Latest Albums
        $latestAlbums = Album::where('is_published', true)
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();

        // Officials (for appearance on homepage)
        $officials = Official::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        // Village Stats (Realtime DB Count + Cached for performance)
        $stats = \Illuminate\Support\Facades\Cache::remember('home.village_stats', 300, function () {
            $residentCount = \App\Models\Resident::active()->count();
            $familyCount = \App\Models\Resident::active()->where('is_head_of_family', true)->count();
            $padukuhanCount = \App\Models\Padukuhan::count();

            return [
                'population' => $residentCount > 0 ? number_format($residentCount, 0, ',', '.') : \App\Models\Setting::getValue('village_population', '28.394'),
                'families'   => $familyCount > 0 ? number_format($familyCount, 0, ',', '.') : \App\Models\Setting::getValue('village_families', '9.800'),
                'padukuhan'  => $padukuhanCount > 0 ? (string)$padukuhanCount : \App\Models\Setting::getValue('village_padukuhan', '18'),
                'area'       => \App\Models\Setting::getValue('village_area', '948,6'),
            ];
        });

        // IDM Latest Score
        $idmScore = IdmScore::orderByDesc('year')->first();

        // APBKal Summary
        $budget = BudgetPeriod::where('status', 'active')->first();

        // FAQ highlights
        $faqs = Faq::where('is_published', true)
            ->orderBy('sort_order')
            ->limit(5)
            ->get();

        // Development in progress
        $ongoingDevelopments = Development::where('status', 'ongoing')
            ->orderByDesc('start_date')
            ->limit(3)
            ->get();

        return view('home', compact(
            'banners',
            'quickLinks',
            'featuredArticles',
            'latestArticles',
            'upcomingEvents',
            'pinnedAnnouncements',
            'latestAlbums',
            'officials',
            'stats',
            'idmScore',
            'budget',
            'faqs',
            'ongoingDevelopments',
        ));
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $articles = Article::published()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get(['id', 'title', 'slug', 'published_at']);

        $events = Event::where('is_published', true)
            ->where('title', 'like', "%{$query}%")
            ->limit(3)
            ->get(['id', 'title', 'slug']);

        return response()->json([
            'articles' => $articles->map(fn($a) => [
                'title' => $a->title,
                'url'   => route('berita.show', $a->slug),
                'date'  => $a->published_at?->diffForHumans(),
                'type'  => 'Berita',
            ]),
            'events' => $events->map(fn($e) => [
                'title' => $e->title,
                'url'   => route('agenda.show', $e->slug),
                'type'  => 'Agenda',
            ]),
        ]);
    }

    public function weather()
    {
        // Placeholder for OpenWeatherMap API integration
        return response()->json([
            'temp' => rand(25, 32),
            'desc' => 'Cerah Berawan',
            'humidity' => rand(60, 80),
            'city' => 'Sleman',
        ]);
    }
}
