<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $featuredPosts = Post::with(['category', 'user'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $categories = Category::withCount(['posts' => function ($query) {
            $query->where('status', 'published');
        }])->get();

        $latestPosts = Post::with(['category', 'user'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('welcome', compact('featuredPosts', 'categories', 'latestPosts'));
    }

    public function dashboard()
    {
        $totalPosts = Post::count();
        $publishedPosts = Post::where('status', 'published')->count();
        $totalCategories = Category::count();
        $totalComments = \App\Models\Comment::count();

        $recentPosts = Post::with(['category'])
            ->latest()
            ->take(5)
            ->get();

        $categories = Category::withCount('posts')->get();

        return view('dashboard', compact(
            'totalPosts',
            'publishedPosts',
            'totalCategories',
            'totalComments',
            'recentPosts',
            'categories'
        ));
    }
}
