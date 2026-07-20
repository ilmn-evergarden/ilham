<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display a listing of the user's blog posts.
     */
    public function index(Request $request): View
    {
        $query = $request->user()->blogs();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->orderByDesc('published_at')->orderByDesc('created_at');

        $blogs = $query->paginate(12)->withQueryString();

        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog post.
     */
    public function create(): View
    {
        return view('blogs.create');
    }

    /**
     * Store a newly created blog post.
     */
    public function store(StoreBlogRequest $request): RedirectResponse
    {
        $data            = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['slug']    = Str::slug($data['slug']);

        // When saving as Draft, clear published_at
        if ($data['status'] === 'Draft') {
            $data['published_at'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('blogs/thumbnails', 'public');
        }

        Blog::create($data);

        return redirect()->route('blogs.index')
            ->with('status', 'blog-created');
    }

    /**
     * Show the form for editing the specified blog post.
     */
    public function edit(Request $request, Blog $blog): View
    {
        abort_if($blog->user_id !== $request->user()->id, 403);

        return view('blogs.edit', compact('blog'));
    }

    /**
     * Update the specified blog post.
     */
    public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {
        abort_if($blog->user_id !== $request->user()->id, 403);

        $data         = $request->validated();
        $data['slug'] = Str::slug($data['slug']);

        if ($data['status'] === 'Draft') {
            $data['published_at'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            if ($blog->thumbnail) {
                Storage::disk('public')->delete($blog->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('blogs/thumbnails', 'public');
        }

        $blog->update($data);

        return redirect()->route('blogs.index')
            ->with('status', 'blog-updated');
    }

    /**
     * Remove the specified blog post and its thumbnail.
     */
    public function destroy(Request $request, Blog $blog): RedirectResponse
    {
        abort_if($blog->user_id !== $request->user()->id, 403);

        if ($blog->thumbnail) {
            Storage::disk('public')->delete($blog->thumbnail);
        }

        $blog->delete();

        return redirect()->route('blogs.index')
            ->with('status', 'blog-deleted');
    }
}
