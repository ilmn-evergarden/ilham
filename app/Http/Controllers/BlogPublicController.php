<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\View\View;

class BlogPublicController extends Controller
{
    /**
     * Display all published articles, newest first.
     */
    public function index(): View
    {
        $blogs = Blog::published()->with('user')->paginate(9);

        return view('blog.index', compact('blogs'));
    }

    /**
     * Display the specified published article.
     * Returns 404 for drafts so they cannot be accessed directly.
     */
    public function show(string $slug): View
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'Published')
            ->whereNotNull('published_at')
            ->with('user')
            ->firstOrFail();

        // Sidebar: latest 5 other published posts
        $recent = Blog::published()
            ->where('id', '!=', $blog->id)
            ->limit(5)
            ->get(['id', 'title', 'slug', 'thumbnail', 'published_at']);

        return view('blog.show', compact('blog', 'recent'));
    }
}
