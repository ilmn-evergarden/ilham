<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Project;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $projects = Project::orderBy('updated_at', 'desc')->get();
        $blogs = Blog::published()->orderBy('updated_at', 'desc')->get();

        $content = view('sitemap.index', compact('projects', 'blogs'))->render();

        $xmlHeader = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";

        return response($xmlHeader . $content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
